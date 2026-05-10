<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Passager.php';
require_once __DIR__ . '/../models/Conducteur.php';
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Notification.php';

class ProfilController extends Controller
{
    /* =============================================
       TABLEAU DE BORD (conducteur / passager)
       ============================================= */
    public function dashboard()
    {
        $this->requireLogin();

        $user   = $_SESSION['user'];
        $pdo    = Database::getInstance();
        $role   = $user['role'];
        $idUser = $user['idUtilisateur'];

        $data = [
            'user'        => $user,
            'mesTrajets'  => 0,
            'mesResas'    => 0,
            'disponibes'  => 0,
            'noteMoyenne' => '-',
            'derniersTrajets' => [],
        ];

        // --- Conducteur ---
        if ($role === 'Conducteur') {
            $st = $pdo->prepare("SELECT idConducteur, noteMoyenne FROM conducteur WHERE idUtilisateur = :id");
            $st->execute([':id' => $idUser]);
            $conducteur = $st->fetch();

            if ($conducteur) {
                $idConducteur = $conducteur['idConducteur'];
                $data['noteMoyenne'] = number_format($conducteur['noteMoyenne'], 1);

                $st = $pdo->prepare("SELECT COUNT(*) FROM trajet WHERE idConducteur = :id");
                $st->execute([':id' => $idConducteur]);
                $data['mesTrajets'] = (int) $st->fetchColumn();

                $st = $pdo->prepare(
                    "SELECT COUNT(*) FROM reservation r
                     JOIN trajet t ON r.idTrajet = t.idTrajet
                     WHERE t.idConducteur = :id"
                );
                $st->execute([':id' => $idConducteur]);
                $data['mesResas'] = (int) $st->fetchColumn();
            }
        }

        // --- Passager ---
        if ($role === 'Passager') {
            $st = $pdo->prepare("SELECT idPassager FROM passager WHERE idUtilisateur = :id");
            $st->execute([':id' => $idUser]);
            $passager = $st->fetch();

            if ($passager) {
                $idPassager = $passager['idPassager'];

                $st = $pdo->prepare("SELECT COUNT(*) FROM reservation WHERE idPassager = :id");
                $st->execute([':id' => $idPassager]);
                $data['mesResas'] = (int) $st->fetchColumn();

                $st = $pdo->prepare(
                    "SELECT COALESCE(AVG(note), 0) FROM avis a
                     JOIN reservation r ON a.idReservation = r.idReservation
                     WHERE r.idPassager = :id"
                );
                $st->execute([':id' => $idPassager]);
                $moy = (float) $st->fetchColumn();
                $data['noteMoyenne'] = $moy > 0 ? number_format($moy, 1) : '-';
            }
        }

        // --- Trajets disponibles (tous roles) ---
        $st = $pdo->query(
            "SELECT COUNT(*) FROM trajet WHERE statut = 'Disponible' AND dateDepart >= NOW()"
        );
        $data['disponibes'] = (int) $st->fetchColumn();

        // --- Derniers trajets disponibles ---
        $sql = "SELECT t.*, u.nom, u.prenom, c.noteMoyenne AS noteConducteur
                FROM trajet t
                JOIN conducteur c  ON t.idConducteur = c.idConducteur
                JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                WHERE t.statut = 'Disponible' AND t.dateDepart >= NOW()
                ORDER BY t.dateDepart ASC
                LIMIT 5";
        $st = $pdo->query($sql);
        $data['derniersTrajets'] = $st->fetchAll();

        $this->render('dashboard/index', $data);
    }

    /* =============================================
       NOTIFICATIONS (page dediee)
       ============================================= */
    public function notifications()
    {
        $this->requireLogin();

        $notif  = new Notification();
        $idUser = $_SESSION['user']['idUtilisateur'];
        $notifications = $notif->findByUtilisateur($idUser);

        $this->render('profil/notifications', [
            'notifications' => $notifications,
        ]);
    }

    /* =============================================
       PROFIL (info + notifications recentes)
       ============================================= */
    public function index()
    {
        $this->requireLogin();

        $userModel     = new Utilisateur();
        $notif         = new Notification();
        $idUser        = $_SESSION['user']['idUtilisateur'];
        $user          = $userModel->findById($idUser);
        $notifications = $notif->findByUtilisateur($idUser);

        $this->render('profil/index', [
            'user'          => $user,
            'notifications' => array_slice($notifications, 0, 5),
        ]);
    }

    /* =============================================
       MODIFIER PROFIL
       ============================================= */
    public function edit()
    {
        $this->requireLogin();

        $userModel = new Utilisateur();
        $idUser    = $_SESSION['user']['idUtilisateur'];
        $user      = $userModel->findById($idUser);

        $erreur = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom       = trim($_POST['nom']       ?? '');
            $prenom    = trim($_POST['prenom']    ?? '');
            $email     = trim($_POST['email']     ?? '');
            $telephone = trim($_POST['telephone'] ?? '');

            if (!$nom || !$prenom || !$email) {
                $erreur = "Nom, prenom et email sont obligatoires.";
            } else {
                $userModel->update($idUser, $nom, $prenom, $email, $telephone);
                $_SESSION['user']['nom']       = $nom;
                $_SESSION['user']['prenom']    = $prenom;
                $_SESSION['user']['email']     = $email;
                $_SESSION['user']['telephone'] = $telephone;
                $_SESSION['flash_success']     = "Profil mis a jour.";
                $this->redirect('?controller=profil&action=index');
            }
        }

        $this->render('profil/edit', ['user' => $user, 'erreur' => $erreur]);
    }

    /* =============================================
       CHANGER MOT DE PASSE
       ============================================= */
    public function changerMdp()
    {
        $this->requireLogin();

        $erreur = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ancien  = $_POST['ancien']    ?? '';
            $nouveau = $_POST['nouveau']   ?? '';
            $confirm = $_POST['confirmer'] ?? '';

            $userModel = new Utilisateur();
            $user      = $userModel->findById($_SESSION['user']['idUtilisateur']);

            if (!password_verify($ancien, $user['motDepasse'])) {
                $erreur = "Ancien mot de passe incorrect.";
            } elseif (strlen($nouveau) < 6) {
                $erreur = "Le nouveau mot de passe doit faire au moins 6 caracteres.";
            } elseif ($nouveau !== $confirm) {
                $erreur = "Les mots de passe ne correspondent pas.";
            } else {
                $userModel->changerMotDePasse($user['idUtilisateur'], $nouveau);
                $_SESSION['flash_success'] = "Mot de passe modifie avec succes.";
                $this->redirect('?controller=profil&action=index');
            }
        }

        $this->render('profil/mdp', ['erreur' => $erreur]);
    }
}
