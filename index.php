<?php


spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Gestion des routes simples
$action = $_GET['action'] ?? 'index';

use App\Controllers\BakeryController;
use App\UI\BakeryUI;
use App\Services\BakeryService;
use App\Services\Implementations\FIFOQueueManager;

$controller = new BakeryController();

switch ($action) {
    case 'index':
        echo $controller->index();
        break;
        
    case 'addClient':
        echo $controller->addClient();
        break;
        
    case 'serveNext':
        echo $controller->serveNext();
        break;
        
    case 'getQueueStatus':
        echo $controller->getQueueStatus();
        break;
        
    case 'getStatistics':
        echo $controller->getStatistics();
        break;
        
    case 'clearQueue':
        echo $controller->clearQueue();
        break;
        
    case 'changeQueueType':
        echo $controller->changeQueueType();
        break;
        
    case 'getAddClientForm':
        // Retourne le formulaire d'ajout de client
        $queueManager = new FIFOQueueManager();
        $bakeryService = new BakeryService($queueManager);
        $bakeryUI = new BakeryUI($bakeryService);
        echo $bakeryUI->displayAddClientForm();
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Action non trouvée']);
        break;
}
