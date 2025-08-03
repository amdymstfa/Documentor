<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Services\Database;
use App\Models\Utilisateur;
use App\Models\Role;
use App\Services\UserService;
use App\Services\RoleService;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController; 

// Objects initialization (Dependency Injection)
$pdo = Database::getInstance()->getConnection();

// Models
$userModel = new Utilisateur($pdo);
$roleModel = new Role($pdo);

// Services
$roleService = new RoleService($roleModel);
$userService = new UserService($userModel, $roleService);

// Controllers
$authController = new AuthController($userService);
$dashboardController = new DashboardController($roleService);
$homeController = new HomeController(); 

// Request handling
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/Documentor/public', '', $uri);
$uri = rtrim($uri, '/');
$method = $_SERVER['REQUEST_METHOD'];

// Routes
switch (true) {
    // Route d'accueil
    case ($uri === '' || $uri === '/'):
        $homeController->index();
        break;
    
    // Authentication routes
    case ($uri === '/register' && $method === 'POST'):
        $authController->register();
        break;
        
    case ($uri === '/login' && $method === 'POST'):
        $authController->login();
        break;
    
    // Dashboard routes (GET requests for views)
    case ($uri === '/dashboard/redacteur' && $method === 'GET'):
        $dashboardController->show(1); // Rédacteur = role_id 1
        break;
        
    case ($uri === '/dashboard/validateur' && $method === 'GET'):
        $dashboardController->show(2); // Validateur = role_id 2
        break;
        
    case ($uri === '/dashboard/client' && $method === 'GET'):
        $dashboardController->show(3); // Client = role_id 3
        break;
        
    case ($uri === '/dashboard/generateur' && $method === 'GET'):
        $dashboardController->show(4); // Générateur = role_id 4
        break;
    
    // API route to get user dashboard URL (POST request with user data)
    case ($uri === '/api/dashboard' && $method === 'POST'):
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['role_id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'role_id requis']);
            break;
        }
        
        try {
            $redirectPath = $roleService->getRedirectPath($input['role_id']);
            $roleInfo = $roleService->getRoleInfo($input['role_id']);
            
            echo json_encode([
                'success' => true,
                'redirect_url' => $redirectPath,
                'role_info' => $roleInfo
            ]);
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // Default dashboard
    case ($uri === '/dashboard' && $method === 'GET'):
        $dashboardController->index();
        break;
    
    // API Info route (déplacée vers /api/info)
    case ($uri === '/api/info' && $method === 'GET'):
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'API Documentor',
            'endpoints' => [
                'GET /' => 'Page d\'accueil',
                'POST /register' => 'Inscription utilisateur',
                'POST /login' => 'Connexion utilisateur',
                'POST /api/dashboard' => 'Obtenir l\'URL du dashboard selon le rôle',
                'GET /dashboard/redacteur' => 'Page dashboard rédacteur',
                'GET /dashboard/validateur' => 'Page dashboard validateur', 
                'GET /dashboard/client' => 'Page dashboard client',
                'GET /dashboard/generateur' => 'Page dashboard générateur'
            ]
        ]);
        break;
    
    // 404 Not Found
    default:
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode([
            'success' => false, 
            'message' => 'Route non trouvée',
            'requested_uri' => $uri,
            'method' => $method
        ]);
        break;
}
?>