<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// database connexion test
// use App\Services\Database;

// try {
//     $db = Database::getInstance()->getConnection();
//     echo "✅ Connexion réussie à la base de données.";
// } catch (Exception $e) {
//     echo "❌ Erreur : " . $e->getMessage();
// }
