<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Avis
 * Avis laisse par un passager apres une reservation terminee.
 */
class Avis extends Model
{
    protected $table      = 'avis';
    protected $primaryKey = 'idAvis';

    /**
     * Tous les avis avec details (multi-jointures).
     */
    public function findAllAvecDetails()
    {
        $sql = "SELECT a.*, t.villeDepart, t.villeArrivee,
                       up.nom AS nomPassager, up.prenom AS prenomPassager,
                       uc.nom AS nomConducteur, uc.prenom AS prenomConducteur
                FROM avis a
                INNER JOIN reservation r  ON a.idReservation = r.idReservation
                INNER JOIN passager p     ON r.idPassager    = p.idPassager
                INNER JOIN utilisateur up ON p.idUtilisateur = up.idUtilisateur
                INNER JOIN trajet t       ON r.idTrajet      = t.idTrajet
                INNER JOIN conducteur c   ON t.idConducteur  = c.idConducteur
                INNER JOIN utilisateur uc ON c.idUtilisateur = uc.idUtilisateur
                ORDER BY a.dateAvis DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Avis recus par un conducteur.
     */
    public function findByConducteur($idConducteur)
    {
        $sql = "SELECT a.*, t.villeDepart, t.villeArrivee,
                       u.nom AS nomPassager, u.prenom AS prenomPassager
                FROM avis a
                INNER JOIN reservation r ON a.idReservation = r.idReservation
                INNER JOIN trajet t      ON r.idTrajet      = t.idTrajet
                INNER JOIN passager p    ON r.idPassager    = p.idPassager
                INNER JOIN utilisateur u ON p.idUtilisateur = u.idUtilisateur
                WHERE t.idConducteur = :id
                ORDER BY a.dateAvis DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idConducteur]);
        return $stmt->fetchAll();
    }

    /**
     * Verifie si un avis existe deja pour une reservation.
     */
    public function existePourReservation($idReservation)
    {
        $sql  = "SELECT idAvis FROM avis WHERE idReservation = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idReservation]);
        return (bool) $stmt->fetch();
    }

    /**
     * Ajout d'un avis.
     */
    public function ajouter($idReservation, $note, $commentaire)
    {
        $sql  = "INSERT INTO avis (idReservation, note, commentaire)
                 VALUES (:r, :n, :c)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':r' => $idReservation,
            ':n' => $note,
            ':c' => $commentaire,
        ]);
    }

    /**
     * Note moyenne globale.
     */
    public function noteMoyenneGlobale()
    {
        $sql = "SELECT AVG(note) AS moy FROM avis";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();
        return $row['moy'] ? round((float) $row['moy'], 2) : 0;
    }

    /**
     * Statistiques : repartition des notes (1 a 5).
     */
    public function repartitionNotes()
    {
        $sql = "SELECT note, COUNT(*) AS total FROM avis GROUP BY note ORDER BY note";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
