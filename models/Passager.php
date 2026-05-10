<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Passager
 */
class Passager extends Model
{
    protected $table      = 'passager';
    protected $primaryKey = 'idPassager';

    /**
     * Recupere un passager avec ses informations utilisateur.
     */
    public function findAvecUtilisateur($idPassager)
    {
        $sql = "SELECT p.*, u.nom, u.prenom, u.email, u.telephone
                FROM passager p
                INNER JOIN utilisateur u ON p.idUtilisateur = u.idUtilisateur
                WHERE p.idPassager = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idPassager]);
        return $stmt->fetch();
    }

    /**
     * Liste tous les passagers avec leurs informations utilisateur.
     */
    public function findAllAvecUtilisateur()
    {
        $sql = "SELECT p.*, u.nom, u.prenom, u.email, u.telephone
                FROM passager p
                INNER JOIN utilisateur u ON p.idUtilisateur = u.idUtilisateur
                ORDER BY u.nom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Mise a jour des preferences d'un passager.
     */
    public function updatePreferences($idPassager, $preferences)
    {
        $sql = "UPDATE passager SET preferences = :pref WHERE idPassager = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':pref' => $preferences, ':id' => $idPassager]);
    }
}
