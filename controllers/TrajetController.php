<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Notification.php';

/**
 * Controleur des trajets.
 */
class TrajetController extends Controller
{
    /**
     * Liste publique des trajets actifs avec recherche multi-criteres.
     */
    public function index()
    {
        $trajetModel = new Trajet();

        $vd   = $_GET['villeDepart']  ?? '';
        $va   = $_GET['villeArrivee'] ?? '';
        $date = $_GET['date']         ?? '';

        if ($vd || $va || $date) {
            $trajets = $trajetModel->rechercher($vd, $va, $date);
        } else {
            $trajets = $trajetModel->findActifs();
        }

        $this->render('trajet/index', [
            'trajets' => $trajets,
            'vd'      => $vd,
            'va'      => $va,
            'date'    => $date,
        ]);
    }

    /**
     * Detail d'un trajet.
     */
    public function show()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $trajetModel = new Trajet();
        $resaModel   = new Reservation();

        $trajet = $trajetModel->findDetails($id);
        if (!$trajet) {
            $this->render('errors/404', ['message' => 'Trajet introuvable.']);
            return;
        }

        $placesReservees = $resaModel->placesReservees($id);

        $this->render('trajet/show', [
            'trajet'          => $trajet,
            'placesReservees' => $placesReservees,
        ]);
    }

    /**
     * Liste des trajets du conducteur connecte.
     */
    public function mesTrajets()
    {
        $this->requireRole('Conducteur');

        $userModel    = new Utilisateur();
        $trajetModel  = new Trajet();
        $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

        $trajets = $trajetModel->findByConducteur($idConducteur);

        $this->render('trajet/mes_trajets', ['trajets' => $trajets]);
    }

    /**
     * Creation d'un nouveau trajet (par un conducteur).
     */
    public function create()
    {
        $this->requireRole('Conducteur');

        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vd    = trim($_POST['villeDepart']  ?? '');
            $va    = trim($_POST['villeArrivee'] ?? '');
            $date  = $_POST['dateDepart']        ?? '';
            $prix  = (float) ($_POST['prix']     ?? 0);

            if (!$vd || !$va || !$date || $prix <= 0) {
                $erreur = "Tous les champs sont obligatoires et le prix doit etre positif.";
            } else {
                $userModel    = new Utilisateur();
                $trajetModel  = new Trajet();
                $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

                if ($trajetModel->ajouter($idConducteur, $vd, $va, $date, $prix)) {
                    $_SESSION['flash_success'] = "Trajet ajoute avec succes !";
                    $this->redirect('?controller=trajet&action=mesTrajets');
                } else {
                    $erreur = "Erreur lors de l'ajout du trajet.";
                }
            }
        }

        $this->render('trajet/create', ['erreur' => $erreur]);
    }

    /**
     * Modification d'un trajet par son conducteur.
     */
    public function edit()
    {
        $this->requireRole('Conducteur');

        $id          = (int) ($_GET['id'] ?? 0);
        $trajetModel = new Trajet();
        $userModel   = new Utilisateur();
        $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

        $trajet = $trajetModel->findById($id);
        if (!$trajet || $trajet['idConducteur'] != $idConducteur) {
            $_SESSION['flash_error'] = "Trajet introuvable ou non autorise.";
            $this->redirect('?controller=trajet&action=mesTrajets');
        }

        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vd     = trim($_POST['villeDepart']  ?? '');
            $va     = trim($_POST['villeArrivee'] ?? '');
            $date   = $_POST['dateDepart']        ?? '';
            $prix   = (float) ($_POST['prix']     ?? 0);
            $statut = $_POST['statut']            ?? 'Actif';

            if (!$vd || !$va || !$date || $prix <= 0) {
                $erreur = "Tous les champs sont obligatoires et le prix doit etre positif.";
            } else {
                $trajetModel->modifier($id, $vd, $va, $date, $prix, $statut);
                $_SESSION['flash_success'] = "Trajet modifie avec succes !";
                $this->redirect('?controller=trajet&action=mesTrajets');
            }
        }

        $this->render('trajet/edit', ['trajet' => $trajet, 'erreur' => $erreur]);
    }

    /**
     * Suppression d'un trajet.
     */
    public function delete()
    {
        $this->requireRole('Conducteur');

        $id          = (int) ($_GET['id'] ?? 0);
        $trajetModel = new Trajet();
        $userModel   = new Utilisateur();
        $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

        $trajet = $trajetModel->findById($id);
        if ($trajet && $trajet['idConducteur'] == $idConducteur) {
            $trajetModel->delete($id);
            $_SESSION['flash_success'] = "Trajet supprime.";
        } else {
            $_SESSION['flash_error'] = "Suppression non autorisee.";
        }
        $this->redirect('?controller=trajet&action=mesTrajets');
    }
}
