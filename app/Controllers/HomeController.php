<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        // Charger la vue home
        $this->loadView('home');
    }
    
    private function loadView($view, $data = [])
    {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Inclure la vue
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            // Gestion d'erreur si la vue n'existe pas
            http_response_code(404);
            echo "Vue non trouvée : " . $view;
        }
    }
}