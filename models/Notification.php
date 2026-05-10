<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Notification
 */
class Notification extends Model
{
    protected $table      = 'notification';
    protected $primaryKey = 'idNotification';

    /**
     * Notifications d'un utilisateur (ordre antichronologique).
     */
    public function findByUtilisateur($idUtilisateur)
    {
        $sql  = "SELECT * FROM notification
                 WHERE idUtilisateur = :id
                 ORDER BY dateEnvoi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUtilisateur]);
        return $stmt->fetchAll();
    }

    /**
     * Envoi d'une notification.
     */
    public function envoyer($idUtilisateur, $contenu, $type = 'Info')
    {
        $sql  = "INSERT INTO notification (idUtilisateur, contenu, typeNotif)
                 VALUES (:u, :c, :t)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':u' => $idUtilisateur,
            ':c' => $contenu,
            ':t' => $type,
        ]);
    }

    /**
     * Compte les notifications recentes (24h) pour un utilisateur.
     */
    public function countRecentes($idUtilisateur)
    {
        $sql  = "SELECT COUNT(*) AS total FROM notification
                 WHERE idUtilisateur = :id
                 AND dateEnvoi >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUtilisateur]);
        $row = $stmt->fetch();
        return (int) $row['total'];
    }
}
