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

// Objects initialization (Dependency Injection)
$pdo = Database::getInstance()->getConnection();
$userModel = new Utilisateur($pdo);
$userService = new UserService($userModel);
$authController = new AuthController($userService);

// Request handling
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/Documentor/public', '', $uri);
$uri = rtrim($uri, '/');

$method = $_SERVER['REQUEST_METHOD'];

// Routes
if ($uri === '/register' && $method === 'POST') {
    $authController->register();
    
} elseif ($uri === '/login' && $method === 'POST') {
    $authController->login();
    
} elseif ($uri === '' || $uri === '/') {
    // Default route
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true, 
        'message' => 'API Documentor - Endpoints disponibles: POST /register, POST /login'
    ]);
    
} else {
    // 404 Not Found
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Route non trouvée']);
}
?>