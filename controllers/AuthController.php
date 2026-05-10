<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Notification.php';

/**
 * Controleur d'authentification (inscription, connexion, deconnexion).
 */
class AuthController extends Controller
{
    /**
     * Affichage / traitement du formulaire de connexion.
     */
    public function login()
    {
        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email      = trim($_POST['email'] ?? '');
            $motDepasse = $_POST['motDepasse'] ?? '';

            if (empty($email) || empty($motDepasse)) {
                $erreur = "Veuillez remplir tous les champs.";
            } else {
                $userModel = new Utilisateur();
                $user      = $userModel->verifierConnexion($email, $motDepasse);

                if ($user) {
                    // On stocke l'utilisateur en session (sans le mot de passe)
                    unset($user['motDepasse']);
                    $_SESSION['user'] = $user;
                    $_SESSION['flash_success'] = "Bienvenue " . $user['prenom'] . " !";
                    $this->redirect('?controller=profil&action=dashboard');
                } else {
                    $erreur = "Email ou mot de passe incorrect.";
                }
            }
        }

        $this->render('auth/login', ['erreur' => $erreur]);
    }

    /**
     * Inscription.
     */
    public function register()
    {
        $erreur  = '';
        $succes  = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom        = trim($_POST['nom'] ?? '');
            $prenom     = trim($_POST['prenom'] ?? '');
            $email      = trim($_POST['email'] ?? '');
            $telephone  = trim($_POST['telephone'] ?? '');
            $motDepasse = $_POST['motDepasse'] ?? '';
            $confirm    = $_POST['confirmMdp'] ?? '';
            $role       = $_POST['role'] ?? 'Passager';

            // Validations cote serveur
            if (empty($nom) || empty($prenom) || empty($email) || empty($motDepasse)) {
                $erreur = "Tous les champs obligatoires doivent etre remplis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreur = "Adresse email invalide.";
            } elseif (strlen($motDepasse) < 6) {
                $erreur = "Le mot de passe doit comporter au moins 6 caracteres.";
            } elseif ($motDepasse !== $confirm) {
                $erreur = "Les mots de passe ne correspondent pas.";
            } elseif (!in_array($role, ['Passager', 'Conducteur'])) {
                $erreur = "Role invalide.";
            } else {
                $userModel = new Utilisateur();
                $idUser    = $userModel->inscrire($nom, $prenom, $email, $telephone, $motDepasse, $role);

                if ($idUser) {
                    // Notification de bienvenue
                    $notif = new Notification();
                    $notif->envoyer($idUser, "Bienvenue sur Covoit TN, $prenom !", 'Bienvenue');

                    $_SESSION['flash_success'] = "Inscription reussie ! Vous pouvez maintenant vous connecter.";
                    $this->redirect('?controller=auth&action=login');
                } else {
                    $erreur = "Cet email est deja utilise ou une erreur est survenue.";
                }
            }
        }

        $this->render('auth/register', ['erreur' => $erreur, 'succes' => $succes]);
    }

    /**
     * Deconnexion.
     */
    public function logout()
    {
        session_destroy();
        session_start();
        $_SESSION['flash_success'] = "Vous avez ete deconnecte.";
        $this->redirect('');
    }
}
