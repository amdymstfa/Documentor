<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Services\Database;

// Models
use App\Models\Utilisateur;
use App\Models\Role;

// Domain services
use App\Services\UserService;
use App\Services\RoleService;

// Controllers (views)
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;



// Repositories (domain)
use App\Repositories\DocumentRepository;
use App\Repositories\SectionRepository;

// Implémentations stubs conformes aux interfaces
use App\Services\NullVersionManager;       
use App\Services\NullHistoryManager;        
use App\Services\AllowAllPermissionManager; 

// Controllers (API)
use App\Controllers\DocumentController;
use App\Controllers\SectionController;

// ------------------------------------------
// Bootstrap & DI
// ------------------------------------------
$pdo = Database::getInstance()->getConnection();

// Models
$userModel = new Utilisateur($pdo);
$roleModel = new Role($pdo);
// $testModel = new Test($pdo);

// Services (domain)
$roleService = new RoleService($roleModel);
$userService = new UserService($userModel, $roleService);

// Controllers (views)
$authController = new AuthController($userService);
$dashboardController = new DashboardController($roleService);
$homeController = new HomeController();
// $testController = new testController($testModel);

// Repositories
$documentRepository = new DocumentRepository($pdo);
$sectionRepository  = new SectionRepository($pdo);

// Services stubs
$versionManager    = new NullVersionManager();
$historyManager    = new NullHistoryManager();
$permissionManager = new AllowAllPermissionManager();

// API Controllers
$documentController = new DocumentController(
    $documentRepository,
    $sectionRepository,
    $versionManager,
    $historyManager,
    $permissionManager
);

$sectionController = new SectionController(
    $documentRepository,
    $sectionRepository,
    $versionManager,
    $historyManager,
    $permissionManager
);


// test section

use App\Models\Test ;
use App\Controllers\testControllers;

$testModel = new Test($pdo);
$testController = new testController($testModel);
// ------------------------------------------
// Authentication Helpers
// ------------------------------------------

/**
 * Vérifie si l'utilisateur est authentifié via session
 * @return array|null Données utilisateur ou null si non authentifié
 */
function requireAuthenticatedUser(): ?array {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user'])) {
        return null;
    }
    return $_SESSION['user'];
}

/**
 * Vérifie l'authentification et retourne l'ID utilisateur
 * Termine la requête avec 401 si non authentifié
 * @return int ID de l'utilisateur authentifié
 */
function requireValidUserId(): int {
    $user = requireAuthenticatedUser();
    if (!$user) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Utilisateur non authentifié']);
        exit;
    }
    return (int)$user['id'];
}

/**
 * Envoie une réponse JSON
 */
function jsonResponse(array $data, int $status = 200): void {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
}

// ------------------------------------------
// Request routing
// ------------------------------------------

// Normalisation de l'URI
$rawPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$rawPath = preg_replace('#^/Documentor/public#', '', $rawPath);

if (preg_match('#^/index\.php(/.*)$#', $rawPath, $m)) {
    $rawPath = $m[1];
}

if (isset($_GET['r']) && is_string($_GET['r']) && $_GET['r'] !== '') {
    $rawPath = $_GET['r'];
}

$uri = rtrim($rawPath, '/');
if ($uri === '') $uri = '/';

$method = $_SERVER['REQUEST_METHOD'];

// ------------------------------------------
// Routes
// ------------------------------------------
switch (true) {
    
    // ==========================================
    // PAGES WEB (Views)
    // ==========================================
    
    case ($uri === '' || $uri === '/'):
        $homeController->index();
        break;

    // ==========================================
    // AUTHENTIFICATION
    // ==========================================
    
    case ($uri === '/register' && $method === 'POST'):
        $authController->register();
        break;

    case ($uri === '/login' && $method === 'POST'):
        $authController->login();
        break;

    case ($uri === '/logout' && $method === 'POST'):
        session_destroy();
        jsonResponse(['success' => true, 'message' => 'Déconnexion réussie']);
        break;

    

    // ==========================================
    // DASHBOARDS (Views)
    // ==========================================
    
    case ($uri === '/dashboard' && $method === 'GET'):
        $dashboardController->index();
        break;

    case ($uri === '/dashboard/redacteur' && $method === 'GET'):
        $dashboardController->show(1);
        break;

    case ($uri === '/dashboard/validateur' && $method === 'GET'):
        $dashboardController->show(2);
        break;

    case ($uri === '/dashboard/client' && $method === 'GET'):
        $dashboardController->show(3);
        break;

    case ($uri === '/dashboard/generateur' && $method === 'GET'):
        $dashboardController->show(4);
        break;

    // ==========================================
    // API - INFORMATIONS SYSTÈME
    // ==========================================
    
    case ($uri === '/api/info' && $method === 'GET'):
        jsonResponse([
            'success' => true,
            'message' => 'API Documentor',
            'version' => '1.0.0',
            'endpoints' => [
                // Auth
                'POST /register' => 'Inscription utilisateur',
                'POST /login' => 'Connexion utilisateur',
                'POST /logout' => 'Déconnexion utilisateur',
                
                // User
                'GET /api/user' => 'Informations utilisateur connecté',
                
                // Documents
                'GET /api/documents' => 'Liste des documents de l\'utilisateur',
                'POST /api/documents' => 'Créer un document',
                'GET /api/documents/{id}' => 'Afficher un document',
                'PATCH /api/documents/{id}' => 'Mettre à jour un document',
                'DELETE /api/documents/{id}' => 'Supprimer un document',
                'POST /api/documents/{id}/sections' => 'Ajouter une section',
                'POST /api/documents/{id}/submit' => 'Soumettre pour validation',
                
                // Sections
                'PATCH /api/sections/{id}' => 'Mettre à jour une section',
                'DELETE /api/sections/{id}' => 'Supprimer une section',
                
                // Dashboards
                'GET /dashboard/redacteur' => 'Dashboard rédacteur',
                'GET /dashboard/validateur' => 'Dashboard validateur',
                'GET /dashboard/client' => 'Dashboard client',
                'GET /dashboard/generateur' => 'Dashboard générateur',
            ]
        ]);
        break;

    case ($uri === '/api/dashboard' && $method === 'POST'):
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['role_id'])) {
            jsonResponse(['success' => false, 'message' => 'role_id requis'], 400);
            break;
        }
        
        try {
            $redirectPath = $roleService->getRedirectPath($input['role_id']);
            $roleInfo = $roleService->getRoleInfo($input['role_id']);
            jsonResponse([
                'success' => true,
                'redirect_url' => $redirectPath,
                'role_info' => $roleInfo,
            ]);
        } catch (Exception $e) {
            jsonResponse(['success' => false, 'message' => $e->getMessage()], 404);
        }
        break;

    // ==========================================
    // API - UTILISATEUR
    // ==========================================
    
    case ($uri === '/api/user' && $method === 'GET'):
        $user = requireAuthenticatedUser();
        
        if (!$user) {
            jsonResponse(['success' => false, 'error' => 'Utilisateur non authentifié'], 401);
            break;
        }
        
        jsonResponse([
            'success' => true,
            'data' => [
                'id' => (int)$user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role' => $user['role_nom'],
                'role_id' => (int)$user['role_id']
            ]
        ]);
        break;

    // ==========================================
    // API - DOCUMENTS
    // ==========================================
    
    case (preg_match('#^/api/documents$#', $uri) === 1 && $method === 'GET'):
        $user = requireAuthenticatedUser();
        
        if (!$user) {
            jsonResponse(['success' => false, 'error' => 'Utilisateur non authentifié'], 401);
            break;
        }
        
        $userId = (int)$user['id'];
        
        try {
            // Utiliser seulement auteur_id (redacteur_id n'existe pas dans votre table)
            $stmt = $pdo->prepare("
                SELECT d.*, s.nom as statut_nom 
                FROM documents d 
                LEFT JOIN statuts s ON s.id = d.statut_id 
                WHERE d.auteur_id = :user_id
                ORDER BY d.id DESC
            ");
            $stmt->execute([':user_id' => $userId]);
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $result = [];
            foreach ($documents as $doc) {
                // Récupérer les sections pour chaque document
                $sectionsStmt = $pdo->prepare("
                    SELECT * FROM sections 
                    WHERE document_id = :doc_id 
                    ORDER BY ordre ASC, id ASC
                ");
                $sectionsStmt->execute([':doc_id' => $doc['id']]);
                $sections = $sectionsStmt->fetchAll(PDO::FETCH_ASSOC);
                
                $result[] = [
                    'id' => (int)$doc['id'],
                    'titre' => $doc['titre'],
                    'statut' => $doc['statut_nom'] ?? 'Brouillon',
                    'redacteur_id' => (int)$doc['auteur_id'], // Mapper auteur_id vers redacteur_id pour le frontend
                    'sections' => array_map(function($s) {
                        return [
                            'id' => (int)$s['id'],
                            'document_id' => (int)$s['document_id'],
                            'titre' => $s['titre'],
                            'contenu' => $s['contenu'] ?? null,
                            'parent_id' => $s['parent_id'] ? (int)$s['parent_id'] : null,
                            'ordre' => (int)($s['ordre'] ?? 1)
                        ];
                    }, $sections)
                ];
            }
            
            jsonResponse([
                'success' => true,
                'data' => $result
            ]);
        } catch (Exception $e) {
            jsonResponse([
                'success' => false,
                'error' => 'Erreur lors de la récupération des documents: ' . $e->getMessage()
            ], 500);
        }
        break;

    case (preg_match('#^/api/documents$#', $uri) === 1 && $method === 'POST'):
        requireValidUserId();
        $documentController->store();
        break;

    case (preg_match('#^/api/documents/(\d+)$#', $uri, $m) === 1 && $method === 'GET'):
        $documentController->show((int)$m[1]);
        break;

    case (preg_match('#^/api/documents/(\d+)$#', $uri, $m) === 1 && $method === 'PATCH'):
        requireValidUserId();
        $documentController->update((int)$m[1]);
        break;

    case (preg_match('#^/api/documents/(\d+)$#', $uri, $m) === 1 && $method === 'DELETE'):
        requireValidUserId();
        $documentController->destroy((int)$m[1]);
        break;

    case (preg_match('#^/api/documents/(\d+)/sections$#', $uri, $m) === 1 && $method === 'POST'):
        requireValidUserId();
        $documentController->addSection((int)$m[1]);
        break;

    case (preg_match('#^/api/documents/(\d+)/submit$#', $uri, $m) === 1 && $method === 'POST'):
        requireValidUserId();
        $documentController->submit((int)$m[1]);
        break;


    case (preg_match('#^/api/test', $uri, $m) === 1 && $method === 'GET'):
        getRedac();
        $documentController->submit((int)$m[1]);
        break;

    // ==========================================
    // API - SECTIONS
    // ==========================================
    
    case (preg_match('#^/api/sections/(\d+)$#', $uri, $m) === 1 && $method === 'PATCH'):
        requireValidUserId();
        $sectionController->update((int)$m[1]);
        break;

    case (preg_match('#^/api/sections/(\d+)$#', $uri, $m) === 1 && $method === 'DELETE'):
        requireValidUserId();
        $sectionController->destroy((int)$m[1]);
        break;

    // ==========================================
    // 404 - ROUTE NON TROUVÉE
    // ==========================================
    
    default:
        jsonResponse([
            'success' => false,
            'message' => 'Route non trouvée',
            'requested_uri' => $uri,
            'method' => $method,
            'available_endpoints' => 'Consultez GET /api/info pour la liste complète'
        ], 404);
        break;
}