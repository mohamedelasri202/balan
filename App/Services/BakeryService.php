<?php

namespace App\Services;

use App\Models\Client;
use App\Services\Interfaces\QueueManagerInterface;


class BakeryService
{
    private QueueManagerInterface $queueManager;

    public function __construct(QueueManagerInterface $queueManager)
    {
        $this->queueManager = $queueManager;
    }

   
    public function addClient(string $firstName, string $order): Client
    {
        $client = new Client($firstName, $order);
        $this->queueManager->enqueue($client);
        return $client;
    }

   
    public function serveNextClient(): ?Client
    {
        return $this->queueManager->dequeue();
    }

   
    public function getNextClient(): ?Client
    {
        return $this->queueManager->peek();
    }

    
    public function getWaitingClients(): array
    {
        return $this->queueManager->getAll();
    }

  
    public function isEmpty(): bool
    {
        return $this->queueManager->isEmpty();
    }
}
