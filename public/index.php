<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Services\Database;
use App\Models\Utilisateur;
use App\Services\UserService;
use App\Controllers\AuthController;

// objects
$pdo = Database::getInstance()->getConnection();
$userModel = new Utilisateur($pdo);
$userService = new UserService($userModel);
$authController = new AuthController($userService);

// request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/Documentor/public', '', $uri);
$uri = rtrim($uri, '/'); 

$method = $_SERVER['REQUEST_METHOD'];



if ($uri === '/register' && $method === 'POST') {
    $authController->register();
} elseif ($uri === '' || $uri === '/') {
    
    echo json_encode(['success' => true, 'message' => 'API Documentor']);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Route non trouvée']);
}
?>