<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Reservation
 */
class Reservation extends Model
{
    protected $table      = 'reservation';
    protected $primaryKey = 'idReservation';

    /**
     * Toutes les reservations avec infos passager + trajet (jointures multi-tables).
     */
    public function findAllAvecDetails()
    {
        $sql = "SELECT r.*, up.nom AS nomPassager, up.prenom AS prenomPassager,
                       t.villeDepart, t.villeArrivee, t.dateDepart, t.prixParPersonne,
                       uc.nom AS nomConducteur, uc.prenom AS prenomConducteur
                FROM reservation r
                INNER JOIN passager p     ON r.idPassager = p.idPassager
                INNER JOIN utilisateur up ON p.idUtilisateur = up.idUtilisateur
                INNER JOIN trajet t       ON r.idTrajet = t.idTrajet
                INNER JOIN conducteur c   ON t.idConducteur = c.idConducteur
                INNER JOIN utilisateur uc ON c.idUtilisateur = uc.idUtilisateur
                ORDER BY r.dateReservation DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Reservations effectuees par un passager.
     */
    public function findByPassager($idPassager)
    {
        $sql = "SELECT r.*, t.villeDepart, t.villeArrivee, t.dateDepart, t.prixParPersonne,
                       u.nom AS nomConducteur, u.prenom AS prenomConducteur
                FROM reservation r
                INNER JOIN trajet t       ON r.idTrajet = t.idTrajet
                INNER JOIN conducteur c   ON t.idConducteur = c.idConducteur
                INNER JOIN utilisateur u  ON c.idUtilisateur = u.idUtilisateur
                WHERE r.idPassager = :id
                ORDER BY r.dateReservation DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idPassager]);
        return $stmt->fetchAll();
    }

    /**
     * Reservations recues par un conducteur (sur ses trajets).
     */
    public function findByConducteur($idConducteur)
    {
        $sql = "SELECT r.*, t.villeDepart, t.villeArrivee, t.dateDepart,
                       u.nom AS nomPassager, u.prenom AS prenomPassager, u.telephone
                FROM reservation r
                INNER JOIN trajet t       ON r.idTrajet = t.idTrajet
                INNER JOIN passager p     ON r.idPassager = p.idPassager
                INNER JOIN utilisateur u  ON p.idUtilisateur = u.idUtilisateur
                WHERE t.idConducteur = :id
                ORDER BY r.dateReservation DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idConducteur]);
        return $stmt->fetchAll();
    }

    /**
     * Detail d'une reservation.
     */
    public function findDetails($idReservation)
    {
        $sql = "SELECT r.*, t.villeDepart, t.villeArrivee, t.dateDepart, t.prixParPersonne,
                       t.idConducteur, u.nom AS nomPassager, u.prenom AS prenomPassager
                FROM reservation r
                INNER JOIN trajet t       ON r.idTrajet = t.idTrajet
                INNER JOIN passager p     ON r.idPassager = p.idPassager
                INNER JOIN utilisateur u  ON p.idUtilisateur = u.idUtilisateur
                WHERE r.idReservation = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idReservation]);
        return $stmt->fetch();
    }

    /**
     * Reservation par un passager pour un trajet.
     */
    public function reserver($idPassager, $idTrajet, $nbPlaces)
    {
        $sql = "INSERT INTO reservation (idPassager, idTrajet, nbPlacesReservees, statut)
                VALUES (:p, :t, :nb, 'En attente')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':p'  => $idPassager,
            ':t'  => $idTrajet,
            ':nb' => $nbPlaces,
        ]);
    }

    /**
     * Mise a jour du statut d'une reservation.
     */
    public function changerStatut($idReservation, $statut)
    {
        $sql  = "UPDATE reservation SET statut = :s WHERE idReservation = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':s' => $statut, ':id' => $idReservation]);
    }

    /**
     * Compte les places deja reservees (confirmees) pour un trajet.
     */
    public function placesReservees($idTrajet)
    {
        $sql = "SELECT COALESCE(SUM(nbPlacesReservees), 0) AS total
                FROM reservation
                WHERE idTrajet = :id AND statut IN ('Confirmee','En attente')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idTrajet]);
        $row = $stmt->fetch();
        return (int) $row['total'];
    }

    /**
     * Statistiques : nombre de reservations par statut.
     */
    public function statsParStatut()
    {
        $sql = "SELECT statut, COUNT(*) AS total FROM reservation GROUP BY statut";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Statistiques : top 5 des passagers les plus actifs.
     */
    public function topPassagers()
    {
        $sql = "SELECT u.nom, u.prenom, COUNT(r.idReservation) AS nbReservations
                FROM reservation r
                INNER JOIN passager p     ON r.idPassager = p.idPassager
                INNER JOIN utilisateur u  ON p.idUtilisateur = u.idUtilisateur
                GROUP BY r.idPassager
                ORDER BY nbReservations DESC
                LIMIT 5";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
