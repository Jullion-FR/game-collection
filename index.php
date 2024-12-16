<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Chargez le fichier .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Accédez aux variables d'environnement
$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

echo "Database Host: $dbHost";
echo "Deployé sur le repo du groupe"
?>
