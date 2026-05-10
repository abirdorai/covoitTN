<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Voiture.php';
require_once __DIR__ . '/../models/Utilisateur.php';

/**
 * Controleur des voitures (uniquement pour les conducteurs).
 */
class VoitureController extends Controller
{
    /**
     * Liste des voitures du conducteur connecte.
     */
    public function index()
    {
        $this->requireRole('Conducteur');

        $userModel    = new Utilisateur();
        $voitureModel = new Voiture();
        $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

        $voitures = $voitureModel->findByConducteur($idConducteur);

        $this->render('voiture/index', ['voitures' => $voitures]);
    }

    /**
     * Ajout d'une voiture.
     */
    public function create()
    {
        $this->requireRole('Conducteur');

        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marque  = trim($_POST['marque']  ?? '');
            $modele  = trim($_POST['modele']  ?? '');
            $plaque  = trim($_POST['plaque']  ?? '');
            $places  = (int) ($_POST['places'] ?? 4);

            if (!$marque || !$plaque || $places < 1) {
                $erreur = "Marque, plaque et nombre de places sont obligatoires.";
            } else {
                $userModel    = new Utilisateur();
                $voitureModel = new Voiture();
                $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);
                if ($voitureModel->ajouter($idConducteur, $marque, $modele, $plaque, $places)) {
                    $_SESSION['flash_success'] = "Voiture ajoutee avec succes !";
                    $this->redirect('?controller=voiture&action=index');
                } else {
                    $erreur = "Erreur (peut-etre la plaque existe deja).";
                }
            }
        }

        $this->render('voiture/create', ['erreur' => $erreur]);
    }

    /**
     * Modification d'une voiture.
     */
    public function edit()
    {
        $this->requireRole('Conducteur');

        $id           = (int) ($_GET['id'] ?? 0);
        $voitureModel = new Voiture();
        $userModel    = new Utilisateur();
        $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

        $voiture = $voitureModel->findById($id);
        if (!$voiture || $voiture['idConducteur'] != $idConducteur) {
            $_SESSION['flash_error'] = "Voiture introuvable ou non autorisee.";
            $this->redirect('?controller=voiture&action=index');
        }

        $erreur = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marque  = trim($_POST['marque']  ?? '');
            $modele  = trim($_POST['modele']  ?? '');
            $plaque  = trim($_POST['plaque']  ?? '');
            $places  = (int) ($_POST['places'] ?? 4);

            if (!$marque || !$plaque || $places < 1) {
                $erreur = "Champs invalides.";
            } else {
                $voitureModel->modifier($id, $marque, $modele, $plaque, $places);
                $_SESSION['flash_success'] = "Voiture modifiee.";
                $this->redirect('?controller=voiture&action=index');
            }
        }

        $this->render('voiture/edit', ['voiture' => $voiture, 'erreur' => $erreur]);
    }

    /**
     * Suppression d'une voiture.
     */
    public function delete()
    {
        $this->requireRole('Conducteur');
        $id           = (int) ($_GET['id'] ?? 0);
        $voitureModel = new Voiture();
        $userModel    = new Utilisateur();
        $idConducteur = $userModel->getIdConducteur($_SESSION['user']['idUtilisateur']);

        $voiture = $voitureModel->findById($id);
        if ($voiture && $voiture['idConducteur'] == $idConducteur) {
            $voitureModel->delete($id);
            $_SESSION['flash_success'] = "Voiture supprimee.";
        }
        $this->redirect('?controller=voiture&action=index');
    }
}
