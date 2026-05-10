<?php
/**
 * Point d'entree unique de l'application Covoit TN.
 * Architecture MVC + PDO + POO.
 */

// Sessions
session_start();

// URL de base (a adapter si vous installez dans un sous-dossier)
define('BASE_URL', 'index.php');

// Affichage des erreurs en dev. A desactiver en production.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Routeur
require_once __DIR__ . '/core/Router.php';
$router = new Router();
$router->dispatch();
