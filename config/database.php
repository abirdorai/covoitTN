<?php
/**
 * Classe Database - Connexion a la base de donnees via PDO (Singleton)
 * Permet d'avoir une seule instance de connexion partagee dans toute l'application.
 */
class Database
{
    // Parametres de connexion (a adapter selon votre environnement)
    private static $host    = 'localhost';
    private static $dbname  = 'covoi_tn';
    private static $user    = 'root';
    private static $pass    = '';
    private static $charset = 'utf8mb4';

    // Instance unique PDO (Singleton)
    private static $instance = null;

    /**
     * Retourne l'instance PDO unique.
     * Cree la connexion si elle n'existe pas encore.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . self::$host
                 . ';dbname=' . self::$dbname
                 . ';charset=' . self::$charset;

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                die('Erreur de connexion a la base de donnees : ' . $e->getMessage());
            }
        }
        return self::$instance;
    }

    // Empeche le clonage de l'instance
    private function __construct() {}
    private function __clone() {}
}
