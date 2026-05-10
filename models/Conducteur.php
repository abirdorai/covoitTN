<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Conducteur
 * Lie a la table 'conducteur' (relation 1-1 avec utilisateur).
 */
class Conducteur extends Model
{
    protected $table      = 'conducteur';
    protected $primaryKey = 'idConducteur';

    /**
     * Liste tous les conducteurs avec leurs informations utilisateur (jointure).
     */
    public function findAllAvecUtilisateur()
    {
        $sql = "SELECT c.*, u.nom, u.prenom, u.email, u.telephone
                FROM conducteur c
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                ORDER BY c.noteMoyenne DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recupere un conducteur avec ses informations utilisateur.
     */
    public function findAvecUtilisateur($idConducteur)
    {
        $sql = "SELECT c.*, u.nom, u.prenom, u.email, u.telephone
                FROM conducteur c
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                WHERE c.idConducteur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idConducteur]);
        return $stmt->fetch();
    }

    /**
     * Validation du permis par un admin.
     */
    public function validerPermis($idConducteur)
    {
        $sql  = "UPDATE conducteur SET permisValide = 1 WHERE idConducteur = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $idConducteur]);
    }

    /**
     * Mise a jour de la note moyenne d'un conducteur a partir des avis recus.
     */
    public function recalculerNoteMoyenne($idConducteur)
    {
        $sql = "SELECT AVG(a.note) AS moy
                FROM avis a
                INNER JOIN reservation r ON a.idReservation = r.idReservation
                INNER JOIN trajet t      ON r.idTrajet    = t.idTrajet
                WHERE t.idConducteur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idConducteur]);
        $row = $stmt->fetch();
        $moy = $row['moy'] !== null ? (float) $row['moy'] : 0;

        $sql2 = "UPDATE conducteur SET noteMoyenne = :moy WHERE idConducteur = :id";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->execute([':moy' => $moy, ':id' => $idConducteur]);
        return $moy;
    }
}
