<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Modele Utilisateur
 * Gere les operations CRUD sur la table 'utilisateur'.
 */
class Utilisateur extends Model
{
    protected $table      = 'utilisateur';
    protected $primaryKey = 'idUtilisateur';

    /**
     * Recherche un utilisateur par email (utile pour la connexion).
     */
    public function findByEmail($email)
    {
        $sql  = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Inscription : creer un utilisateur + son profil specifique (Conducteur/Passager/Admin).
     * Retourne l'id de l'utilisateur cree, ou false en cas d'erreur.
     */
    public function inscrire($nom, $prenom, $email, $telephone, $motDepasse, $role)
    {
        // Verification d'unicite de l'email
        if ($this->findByEmail($email)) {
            return false;
        }

        // Hashage du mot de passe (jamais en clair en BD)
        $hash = password_hash($motDepasse, PASSWORD_DEFAULT);

        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO utilisateur (nom, prenom, email, telephone, motDepasse, role)
                    VALUES (:nom, :prenom, :email, :tel, :mdp, :role)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nom'    => $nom,
                ':prenom' => $prenom,
                ':email'  => $email,
                ':tel'    => $telephone,
                ':mdp'    => $hash,
                ':role'   => $role,
            ]);
            $idUser = (int) $this->db->lastInsertId();

            // Creation du profil specifique en fonction du role
            if ($role === 'Conducteur') {
                $stmt = $this->db->prepare(
                    "INSERT INTO conducteur (idUtilisateur, permisValide, noteMoyenne) VALUES (:id, 0, 0)"
                );
                $stmt->execute([':id' => $idUser]);
            } elseif ($role === 'Passager') {
                $stmt = $this->db->prepare(
                    "INSERT INTO passager (idUtilisateur, preferences) VALUES (:id, '')"
                );
                $stmt->execute([':id' => $idUser]);
            } elseif ($role === 'Admin') {
                $stmt = $this->db->prepare(
                    "INSERT INTO admin (idUtilisateur) VALUES (:id)"
                );
                $stmt->execute([':id' => $idUser]);
            }

            $this->db->commit();
            return $idUser;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Verifie le mot de passe pour la connexion.
     * Retourne le tableau utilisateur si OK, false sinon.
     */
    public function verifierConnexion($email, $motDepasse)
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($motDepasse, $user['motDepasse'])) {
            return $user;
        }
        return false;
    }

    /**
     * Mise a jour des informations d'un utilisateur (sans mot de passe).
     */
    public function update($id, $nom, $prenom, $email, $telephone)
    {
        $sql = "UPDATE utilisateur
                SET nom = :nom, prenom = :prenom, email = :email, telephone = :tel
                WHERE idUtilisateur = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nom'    => $nom,
            ':prenom' => $prenom,
            ':email'  => $email,
            ':tel'    => $telephone,
            ':id'     => $id,
        ]);
    }

    /**
     * Modification du mot de passe.
     */
    public function changerMotDePasse($id, $nouveau)
    {
        $hash = password_hash($nouveau, PASSWORD_DEFAULT);
        $sql  = "UPDATE utilisateur SET motDepasse = :mdp WHERE idUtilisateur = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':mdp' => $hash, ':id' => $id]);
    }

    /**
     * Recherche multi-criteres (nom, email, role).
     */
    public function rechercher($nom = '', $email = '', $role = '')
    {
        $sql    = "SELECT * FROM utilisateur WHERE 1=1";
        $params = [];

        if (!empty($nom)) {
            $sql .= " AND (nom LIKE :nom OR prenom LIKE :nom)";
            $params[':nom'] = "%$nom%";
        }
        if (!empty($email)) {
            $sql .= " AND email LIKE :email";
            $params[':email'] = "%$email%";
        }
        if (!empty($role)) {
            $sql .= " AND role = :role";
            $params[':role'] = $role;
        }

        $sql .= " ORDER BY idUtilisateur DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Retourne l'identifiant Conducteur lie a un utilisateur.
     */
    public function getIdConducteur($idUtilisateur)
    {
        $sql = "SELECT idConducteur FROM conducteur WHERE idUtilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUtilisateur]);
        $row = $stmt->fetch();
        return $row ? (int) $row['idConducteur'] : null;
    }

    /**
     * Retourne l'identifiant Passager lie a un utilisateur.
     */
    public function getIdPassager($idUtilisateur)
    {
        $sql = "SELECT idPassager FROM passager WHERE idUtilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUtilisateur]);
        $row = $stmt->fetch();
        return $row ? (int) $row['idPassager'] : null;
    }

    /**
     * Statistiques : nombre d'utilisateurs par role.
     */
    public function statsParRole()
    {
        $sql = "SELECT role, COUNT(*) AS total FROM utilisateur GROUP BY role";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
