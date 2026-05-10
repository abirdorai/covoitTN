<?php
/**
 * Classe Model - Classe mere de tous les modeles
 * Fournit l'acces a l'objet PDO et des methodes utilitaires CRUD generiques.
 */
require_once __DIR__ . '/../config/database.php';

abstract class Model
{
    protected $db;
    protected $table;       // Nom de la table dans la BD
    protected $primaryKey;  // Cle primaire de la table

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Recupere toutes les lignes de la table.
     */
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recherche par cle primaire.
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Suppression par cle primaire.
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Compte le nombre total de lignes.
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();
        return (int) $row['total'];
    }
}
