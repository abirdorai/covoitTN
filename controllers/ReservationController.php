<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Notification.php';

/**
 * Controleur des reservations.
 */
class ReservationController extends Controller
{
    /**
     * Reservation d'un trajet par un passager.
     */
    public function create()
    {
        $this->requireRole('Passager');

        $idTrajet    = (int) ($_GET['idTrajet'] ?? 0);
        $trajetModel = new Trajet();
        $resaModel   = new Reservation();
        $userModel   = new Utilisateur();
        $notif       = new Notification();

        $trajet = $trajetModel->findDetails($idTrajet);
        if (!$trajet) {
            $_SESSION['flash_error'] = "Trajet introuvable.";
            $this->redirect('?controller=trajet&action=index');
        }

        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nbPlaces = (int) ($_POST['nbPlaces'] ?? 1);
            if ($nbPlaces < 1 || $nbPlaces > 10) {
                $erreur = "Nombre de places invalide.";
            } else {
                $idPassager = $userModel->getIdPassager($_SESSION['user']['idUtilisateur']);
                if ($resaModel->reserver($idPassager, $idTrajet, $nbPlaces)) {
                    // Notification au conducteur : on recupere l'idUtilisateur via la table conducteur
                    require_once __DIR__ . '/../config/database.php';
                    $pdo = Database::getInstance();
                    $st  = $pdo->prepare("SELECT idUtilisateur FROM conducteur WHERE idConducteur = :id");
                    $st->execute([':id' => $trajet['idConducteur']]);
                    $row = $st->fetch();
                    if ($row) {
                        $notif->envoyer(
                            $row['idUtilisateur'],
                            "Nouvelle reservation pour votre trajet {$trajet['villeDepart']} - {$trajet['villeArrivee']}",
                            'Reservation'
                        );
                    }

                    $_SESSION['flash_success'] = "Reservation enregistree (en attente de confirmation).";
                    $this->redirect('?controller=reservation&action=mesReservations');
                } else {
                    $erreur = "Erreur lors de la reservation.";
                }
            }
        }

        $this->render('reservation/create', ['trajet' => $trajet, 'erreur' => $erreur]);
    }

    /**
     * Liste des reservations du passager connecte.
     */
    public function mesReservations()
    {
        $this->requireRole('Passager');

        $userModel  = new Utilisateur();
        $resaModel  = new Reservation();
        $idPassager = $userModel->getIdPassager($_SESSION['user']['idUtilisateur']);

        $reservations = $resaModel->findByPassager($idPassager);

        $this->render('reservation/mes_reservations', ['reservations' => $reservations]);
    }

    /**
     * Reservations recues par le conducteur connecte.
     */
    public function reservationsRecues()
    {
        $this->requireRole('Conducteur');

        $userModel    = new Utilisateur();
        $resaModel    = new Reservation();
        $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

        $reservations = $resaModel->findByConducteur($idConducteur);

        $this->render('reservation/recues', ['reservations' => $reservations]);
    }

    /**
     * Confirmation d'une reservation par le conducteur.
     */
    public function confirmer()
    {
        $this->requireRole('Conducteur');
        $id = (int) ($_GET['id'] ?? 0);

        $resaModel = new Reservation();
        $notif     = new Notification();

        $resa = $resaModel->findDetails($id);
        if ($resa) {
            $resaModel->changerStatut($id, 'Confirmee');

            // Notification au passager
            $sql  = "SELECT idUtilisateur FROM passager WHERE idPassager = :id";
            $pdo  = Database::getInstance();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $resa['idPassager']]);
            $row = $stmt->fetch();
            if ($row) {
                $notif->envoyer($row['idUtilisateur'], "Votre reservation a ete confirmee !", 'Confirmation');
            }
            $_SESSION['flash_success'] = "Reservation confirmee.";
        }
        $this->redirect('?controller=reservation&action=reservationsRecues');
    }

    /**
     * Annulation d'une reservation.
     */
    public function annuler()
    {
        $this->requireLogin();
        $id = (int) ($_GET['id'] ?? 0);

        $resaModel = new Reservation();
        $resaModel->changerStatut($id, 'Annulee');

        $_SESSION['flash_success'] = "Reservation annulee.";

        if ($_SESSION['user']['role'] === 'Conducteur') {
            $this->redirect('?controller=reservation&action=reservationsRecues');
        } else {
            $this->redirect('?controller=reservation&action=mesReservations');
        }
    }

    /**
     * Marquer une reservation comme terminee.
     */
    public function terminer()
    {
        $this->requireRole('Conducteur');
        $id = (int) ($_GET['id'] ?? 0);

        $resaModel = new Reservation();
        $resaModel->changerStatut($id, 'Terminee');

        $_SESSION['flash_success'] = "Reservation marquee comme terminee.";
        $this->redirect('?controller=reservation&action=reservationsRecues');
    }
}
