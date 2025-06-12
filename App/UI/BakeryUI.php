<?php

namespace App\UI;

use App\Services\BakeryService;
use App\Models\Client;

class BakeryUI
{
    private BakeryService $bakeryService;

    public function __construct(BakeryService $bakeryService)
    {
        $this->bakeryService = $bakeryService;
    }

  
    public function displayMenu(): void
    {
        $this->clearScreen();
        echo "🥖 BIENVENUE À LA BOULANGERIE SIMULATOR 🥖\n";
        echo "==========================================\n\n";
        echo "--- MENU ---\n";
        echo "1. Ajouter un client\n";
        echo "2. Servir le prochain client\n";
        echo "3. Voir la file d'attente\n";
        echo "0. Quitter\n";
        echo "Votre choix: ";
    }

 
    public function displayQueueStatus(): void
    {
        $this->clearScreen();
        echo " ÉTAT DE LA FILE D'ATTENTE 🥖\n";
        echo "===============================\n\n";
        
        if ($this->bakeryService->isEmpty()) {
            echo " Aucun client en attente\n\n";
        } else {
            $nextClient = $this->bakeryService->getNextClient();
            echo " PROCHAIN CLIENT À SERVIR:\n";
            echo "----------------------------\n";
            echo $nextClient . "\n\n";

            $waitingClients = $this->bakeryService->getWaitingClients();
            echo "📋 FILE D'ATTENTE COMPLÈTE:\n";
            echo "----------------------------\n";
            foreach ($waitingClients as $index => $client) {
                $position = $index + 1;
                echo "{$position}. {$client}\n";
            }
            echo "\n";
        }
        
        $this->waitForEnter();
    }

   
    public function handleAddClient(): void
    {
        $this->clearScreen();
        echo "AJOUTER UN NOUVEAU CLIENT \n";
        echo "===============================\n\n";
        
        echo "Prénom du client: ";
        $firstName = trim(fgets(STDIN));
        
        echo "Commande (ex: une baguette): ";
        $order = trim(fgets(STDIN));
        
        $client = $this->bakeryService->addClient($firstName, $order);
        
        echo "\n Client ajouté avec succès!\n";
        echo "" . $client . "\n\n";
        $this->waitForEnter();
    }

   
    public function handleServeClient(): void
    {
        $this->clearScreen();
        echo " SERVIR LE PROCHAIN CLIENT \n";
        echo "===============================\n\n";
        
        $client = $this->bakeryService->serveNextClient();
        
        if ($client === null) {
            echo " Aucun client à servir dans la file d'attente.\n\n";
        } else {
            echo " Client servi avec succès!\n";
            echo " " . $client . "\n\n";
        }
        
        $this->waitForEnter();
    }

    
    public function confirmExit(): bool
    {
        echo "\n Êtes-vous sûr de vouloir quitter? (o/n): ";
        $response = trim(fgets(STDIN));
        return strtolower($response) === 'o' || strtolower($response) === 'oui';
    }

    public function displayGoodbye(): void
    {
        $this->clearScreen();
        echo " MERCI D'AVOIR UTILISÉ LA BOULANGERIE SIMULATOR! \n";
        echo "====================================================\n\n";
        echo "À bientôt! \n\n";
    }

    private function clearScreen(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            system('cls');
        } else {
            system('clear');
        }
    }

   
    private function waitForEnter(): void
    {
        echo "Appuyez sur Entrée pour continuer...";
        fgets(STDIN);
    }

 
    public function readChoice(): int
    {
        $input = trim(fgets(STDIN));
        return is_numeric($input) ? (int)$input : -1;
    }
}
