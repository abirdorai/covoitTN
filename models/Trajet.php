<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Trajet
 * Gere les trajets proposes par les conducteurs.
 */
class Trajet extends Model
{
    protected $table      = 'trajet';
    protected $primaryKey = 'idTrajet';

    /**
     * Tous les trajets avec les infos du conducteur (jointure utilisateur + conducteur).
     */
    public function findAllAvecConducteur()
    {
        $sql = "SELECT t.*, u.nom, u.prenom, c.noteMoyenne
                FROM trajet t
                INNER JOIN conducteur c  ON t.idConducteur = c.idConducteur
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                ORDER BY t.dateDepart DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Trajets actifs uniquement (pour l'affichage public).
     */
    public function findActifs()
    {
        $sql = "SELECT t.*, u.nom, u.prenom, c.noteMoyenne
                FROM trajet t
                INNER JOIN conducteur c  ON t.idConducteur = c.idConducteur
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                WHERE t.statut = 'Actif' AND t.dateDepart >= NOW()
                ORDER BY t.dateDepart ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Detail d'un trajet (jointure complete).
     */
    public function findDetails($id)
    {
        $sql = "SELECT t.*, u.nom, u.prenom, u.telephone, u.email, c.noteMoyenne, c.permisValide
                FROM trajet t
                INNER JOIN conducteur c  ON t.idConducteur = c.idConducteur
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                WHERE t.idTrajet = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Trajets d'un conducteur donne.
     */
    public function findByConducteur($idConducteur)
    {
        $sql = "SELECT * FROM trajet WHERE idConducteur = :id ORDER BY dateDepart DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idConducteur]);
        return $stmt->fetchAll();
    }

    /**
     * Recherche multi-criteres : ville depart, ville arrivee, date.
     */
    public function rechercher($villeDepart = '', $villeArrivee = '', $date = '')
    {
        $sql = "SELECT t.*, u.nom, u.prenom, c.noteMoyenne
                FROM trajet t
                INNER JOIN conducteur c  ON t.idConducteur = c.idConducteur
                INNER JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
                WHERE t.statut = 'Actif'";
        $params = [];

        if (!empty($villeDepart)) {
            $sql .= " AND t.villeDepart LIKE :vd";
            $params[':vd'] = "%$villeDepart%";
        }
        if (!empty($villeArrivee)) {
            $sql .= " AND t.villeArrivee LIKE :va";
            $params[':va'] = "%$villeArrivee%";
        }
        if (!empty($date)) {
            $sql .= " AND DATE(t.dateDepart) = :d";
            $params[':d'] = $date;
        }

        $sql .= " ORDER BY t.dateDepart ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Ajout d'un trajet.
     */
    public function ajouter($idConducteur, $villeDepart, $villeArrivee, $dateDepart, $prix)
    {
        $sql = "INSERT INTO trajet (idConducteur, villeDepart, villeArrivee, dateDepart, prixParPersonne, statut)
                VALUES (:c, :vd, :va, :dt, :p, 'Actif')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':c'  => $idConducteur,
            ':vd' => $villeDepart,
            ':va' => $villeArrivee,
            ':dt' => $dateDepart,
            ':p'  => $prix,
        ]);
    }

    /**
     * Modification d'un trajet.
     */
    public function modifier($idTrajet, $villeDepart, $villeArrivee, $dateDepart, $prix, $statut)
    {
        $sql = "UPDATE trajet
                SET villeDepart = :vd, villeArrivee = :va, dateDepart = :dt,
                    prixParPersonne = :p, statut = :s
                WHERE idTrajet = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':vd' => $villeDepart,
            ':va' => $villeArrivee,
            ':dt' => $dateDepart,
            ':p'  => $prix,
            ':s'  => $statut,
            ':id' => $idTrajet,
        ]);
    }

    /**
     * Statistiques : nombre de trajets par ville de depart.
     */
    public function statsParVilleDepart()
    {
        $sql = "SELECT villeDepart, COUNT(*) AS total
                FROM trajet
                GROUP BY villeDepart
                ORDER BY total DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Statistiques : nombre de trajets par statut.
     */
    public function statsParStatut()
    {
        $sql = "SELECT statut, COUNT(*) AS total FROM trajet GROUP BY statut";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recettes totales (somme des prix * places reservees) sur trajets termines.
     */
    public function chiffreAffaires()
    {
        $sql = "SELECT COALESCE(SUM(t.prixParPersonne * r.nbPlacesReservees), 0) AS total
                FROM reservation r
                INNER JOIN trajet t ON r.idTrajet = t.idTrajet
                WHERE r.statut IN ('Confirmee','Terminee')";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();
        return (float) $row['total'];
    }
}
