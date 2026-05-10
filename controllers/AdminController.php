<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Conducteur.php';
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Avis.php';

/**
 * Controleur Admin (espace administrateur).
 */
class AdminController extends Controller
{
    /**
     * Tableau de bord administrateur.
     */
    public function dashboard()
    {
        $this->requireRole('Admin');

        $userModel  = new Utilisateur();
        $trajetMod  = new Trajet();
        $resaMod    = new Reservation();
        $avisMod    = new Avis();

        $data = [
            'totalUtilisateurs' => $userModel->count(),
            'totalTrajets'      => $trajetMod->count(),
            'totalReservations' => $resaMod->count(),
            'totalAvis'         => $avisMod->count(),
            'noteMoyenne'       => $avisMod->noteMoyenneGlobale(),
            'chiffreAffaires'   => $trajetMod->chiffreAffaires(),
        ];

        $this->render('admin/dashboard', $data);
    }

    /**
     * Gestion des utilisateurs.
     */
    public function utilisateurs()
    {
        $this->requireRole('Admin');

        $userModel = new Utilisateur();

        $nom   = $_GET['nom']   ?? '';
        $email = $_GET['email'] ?? '';
        $role  = $_GET['role']  ?? '';

        $users = $userModel->rechercher($nom, $email, $role);

        $this->render('admin/utilisateurs', [
            'users' => $users,
            'nom'   => $nom,
            'email' => $email,
            'role'  => $role,
        ]);
    }

    /**
     * Suppression d'un utilisateur.
     */
    public function deleteUser()
    {
        $this->requireRole('Admin');
        $id = (int) ($_GET['id'] ?? 0);

        // Empeche l'admin de se supprimer lui-meme
        if ($id === (int) $_SESSION['user']['idUtilisateur']) {
            $_SESSION['flash_error'] = "Vous ne pouvez pas supprimer votre propre compte.";
            $this->redirect('?controller=admin&action=utilisateurs');
        }

        $userModel = new Utilisateur();
        $userModel->delete($id);
        $_SESSION['flash_success'] = "Utilisateur supprime.";
        $this->redirect('?controller=admin&action=utilisateurs');
    }

    /**
     * Liste des conducteurs avec validation du permis.
     */
    public function conducteurs()
    {
        $this->requireRole('Admin');

        $cMod = new Conducteur();
        $conducteurs = $cMod->findAllAvecUtilisateur();

        $this->render('admin/conducteurs', ['conducteurs' => $conducteurs]);
    }

    /**
     * Validation du permis.
     */
    public function validerPermis()
    {
        $this->requireRole('Admin');
        $id = (int) ($_GET['id'] ?? 0);
        $cMod = new Conducteur();
        $cMod->validerPermis($id);
        $_SESSION['flash_success'] = "Permis valide.";
        $this->redirect('?controller=admin&action=conducteurs');
    }

    /**
     * Gestion des trajets (vue d'ensemble admin).
     */
    public function trajets()
    {
        $this->requireRole('Admin');

        $tMod    = new Trajet();
        $trajets = $tMod->findAllAvecConducteur();

        $this->render('admin/trajets', ['trajets' => $trajets]);
    }

    /**
     * Suppression admin d'un trajet.
     */
    public function deleteTrajet()
    {
        $this->requireRole('Admin');
        $id = (int) ($_GET['id'] ?? 0);
        $tMod = new Trajet();
        $tMod->delete($id);
        $_SESSION['flash_success'] = "Trajet supprime.";
        $this->redirect('?controller=admin&action=trajets');
    }

    /**
     * Vue d'ensemble des reservations.
     */
    public function reservations()
    {
        $this->requireRole('Admin');

        $rMod          = new Reservation();
        $reservations  = $rMod->findAllAvecDetails();

        $this->render('admin/reservations', ['reservations' => $reservations]);
    }
}
