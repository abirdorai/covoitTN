<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Voiture
 */
class Voiture extends Model
{
    protected $table      = 'voiture';
    protected $primaryKey = 'idVoiture';

    /**
     * Toutes les voitures avec le nom du conducteur (jointure).
     */
    public function findAllAvecConducteur()
    {
        $sql = "SELECT v.*, u.nom, u.prenom
                FROM voiture v
                INNER JOIN conducteur c  ON v.idConducteur = c.idConducteur
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                ORDER BY v.idVoiture DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Liste les voitures appartenant a un conducteur.
     */
    public function findByConducteur($idConducteur)
    {
        $sql  = "SELECT * FROM voiture WHERE idConducteur = :id ORDER BY marque";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idConducteur]);
        return $stmt->fetchAll();
    }

    /**
     * Ajout d'une voiture.
     */
    public function ajouter($idConducteur, $marque, $modele, $plaque, $places)
    {
        $sql = "INSERT INTO voiture (idConducteur, marque, modele, plaque, placesDisponibles)
                VALUES (:id, :m, :mod, :p, :pl)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'  => $idConducteur,
            ':m'   => $marque,
            ':mod' => $modele,
            ':p'   => $plaque,
            ':pl'  => $places,
        ]);
    }

    /**
     * Modification d'une voiture.
     */
    public function modifier($idVoiture, $marque, $modele, $plaque, $places)
    {
        $sql = "UPDATE voiture
                SET marque = :m, modele = :mod, plaque = :p, placesDisponibles = :pl
                WHERE idVoiture = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':m'   => $marque,
            ':mod' => $modele,
            ':p'   => $plaque,
            ':pl'  => $places,
            ':id'  => $idVoiture,
        ]);
    }

    /**
     * Recherche multi-criteres.
     */
    public function rechercher($marque = '', $modele = '')
    {
        $sql = "SELECT v.*, u.nom, u.prenom
                FROM voiture v
                INNER JOIN conducteur c  ON v.idConducteur = c.idConducteur
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                WHERE 1=1";
        $params = [];

        if (!empty($marque)) {
            $sql .= " AND v.marque LIKE :marque";
            $params[':marque'] = "%$marque%";
        }
        if (!empty($modele)) {
            $sql .= " AND v.modele LIKE :modele";
            $params[':modele'] = "%$modele%";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
