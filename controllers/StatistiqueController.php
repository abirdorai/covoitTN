<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Avis.php';

/**
 * Controleur Statistiques (rapports de synthese).
 */
class StatistiqueController extends Controller
{
    /**
     * Rapport global de statistiques.
     */
    public function index()
    {
        $this->requireRole('Admin');

        $userModel = new Utilisateur();
        $tMod      = new Trajet();
        $rMod      = new Reservation();
        $aMod      = new Avis();

        $data = [
            'usersParRole'      => $userModel->statsParRole(),
            'trajetsParVille'   => $tMod->statsParVilleDepart(),
            'trajetsParStatut'  => $tMod->statsParStatut(),
            'resaParStatut'     => $rMod->statsParStatut(),
            'topPassagers'      => $rMod->topPassagers(),
            'noteMoyenne'       => $aMod->noteMoyenneGlobale(),
            'repartitionNotes'  => $aMod->repartitionNotes(),
            'chiffreAffaires'   => $tMod->chiffreAffaires(),
        ];

        $this->render('statistique/index', $data);
    }
}
