<?php

namespace App\Controllers;

use App\Services\BakeryService;
use App\Services\Implementations\FIFOQueueManager;
use App\UI\BakeryUI;
use Core\Controller;


class BakeryController extends Controller
{
    private BakeryService $bakeryService;
    private BakeryUI $bakeryUI;
    private bool $running = true;

    public function __construct()
    {
        $queueManager = new FIFOQueueManager();
        $this->bakeryService = new BakeryService($queueManager);
        $this->bakeryUI = new BakeryUI($this->bakeryService);
    }

  
    public function run(): void
    {
        while ($this->running) {
            $this->bakeryUI->displayMenu();
            $choice = $this->bakeryUI->readChoice();
            $this->handleChoice($choice);
        }
        
        $this->bakeryUI->displayGoodbye();
    }

   
    private function handleChoice(int $choice): void
    {
        switch ($choice) {
            case 1:
                $this->bakeryUI->handleAddClient();
                break;
                
            case 2:
                $this->bakeryUI->handleServeClient();
                break;
                
            case 3:
                $this->bakeryUI->displayQueueStatus();
                break;
                
            case 0:
                if ($this->bakeryUI->confirmExit()) {
                    $this->running = false;
                }
                break;
                
            default:
                $this->displayError("Choix invalide. Veuillez choisir entre 0 et 3.");
                break;
        }
    }
}
