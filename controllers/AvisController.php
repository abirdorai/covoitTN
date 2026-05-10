<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Avis.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Conducteur.php';

/**
 * Controleur des avis.
 */
class AvisController extends Controller
{
    /**
     * Liste publique des avis.
     */
    public function index()
    {
        $avisModel = new Avis();
        $avis      = $avisModel->findAllAvecDetails();
        $repart    = $avisModel->repartitionNotes();
        $moyenne   = $avisModel->noteMoyenneGlobale();

        $this->render('avis/index', [
            'avis'    => $avis,
            'repart'  => $repart,
            'moyenne' => $moyenne,
        ]);
    }

    /**
     * Le passager laisse un avis sur une reservation terminee.
     */
    public function create()
    {
        $this->requireRole('Passager');

        $idReservation = (int) ($_GET['idReservation'] ?? 0);
        $resaModel     = new Reservation();
        $avisModel     = new Avis();
        $conducteurModel = new Conducteur();

        $resa = $resaModel->findDetails($idReservation);
        if (!$resa || $resa['statut'] !== 'Terminee') {
            $_SESSION['flash_error'] = "Vous ne pouvez laisser un avis que sur une reservation terminee.";
            $this->redirect('?controller=reservation&action=mesReservations');
        }

        if ($avisModel->existePourReservation($idReservation)) {
            $_SESSION['flash_error'] = "Un avis a deja ete laisse pour cette reservation.";
            $this->redirect('?controller=reservation&action=mesReservations');
        }

        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $note  = (int) ($_POST['note'] ?? 0);
            $comm  = trim($_POST['commentaire'] ?? '');

            if ($note < 1 || $note > 5) {
                $erreur = "La note doit etre comprise entre 1 et 5.";
            } else {
                $avisModel->ajouter($idReservation, $note, $comm);
                // Recalcul de la note moyenne du conducteur
                $conducteurModel->recalculerNoteMoyenne($resa['idConducteur'] ?? null ?: $this->getConducteurId($idReservation));

                $_SESSION['flash_success'] = "Merci pour votre avis !";
                $this->redirect('?controller=reservation&action=mesReservations');
            }
        }

        $this->render('avis/create', ['resa' => $resa, 'erreur' => $erreur]);
    }

    /**
     * Petite fonction utilitaire pour retrouver l'id conducteur d'une reservation.
     */
    private function getConducteurId($idReservation)
    {
        require_once __DIR__ . '/../config/database.php';
        $pdo = Database::getInstance();
        $sql = "SELECT t.idConducteur
                FROM reservation r
                INNER JOIN trajet t ON r.idTrajet = t.idTrajet
                WHERE r.idReservation = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $idReservation]);
        $row = $stmt->fetch();
        return $row ? (int) $row['idConducteur'] : null;
    }
}
