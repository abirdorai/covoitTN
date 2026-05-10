<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Avis.php';

/**
 * Controleur de la page d'accueil (visible aux internautes).
 */
class HomeController extends Controller
{
    /**
     * Page d'accueil : liste les trajets a venir + recherche rapide.
     */
    public function index()
    {
        $trajetModel = new Trajet();
        $avisModel   = new Avis();

        $trajets       = $trajetModel->findActifs();
        $noteMoyenne   = $avisModel->noteMoyenneGlobale();
        $totalTrajets  = $trajetModel->count();

        $this->render('home/index', [
            'trajets'      => $trajets,
            'noteMoyenne'  => $noteMoyenne,
            'totalTrajets' => $totalTrajets,
        ]);
    }

    /**
     * Page "A propos" du site.
     */
    public function about()
    {
        $this->render('home/about', []);
    }

    /**
     * Page de contact.
     */
    public function contact()
    {
        $this->render('home/contact', []);
    }
}
