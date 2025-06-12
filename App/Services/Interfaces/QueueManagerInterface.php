<?php

namespace App\Services\Interfaces;

use App\Models\Client;

interface QueueManagerInterface
{
    
    public function enqueue(Client $client): void;

   
    public function dequeue(): ?Client;

   
    public function peek(): ?Client;

  
    public function getAll(): array;

   
    public function isEmpty(): bool;
}
