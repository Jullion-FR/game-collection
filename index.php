<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Chargez le fichier .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'pages/view/landing.php';
?>
