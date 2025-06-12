<?php

namespace App\Services\Implementations;

use App\Models\Client;
use App\Services\Interfaces\QueueManagerInterface;


class FIFOQueueManager implements QueueManagerInterface
{
    private array $queue = [];

    public function enqueue(Client $client): void
    {
        $this->queue[] = $client;
    }

    public function dequeue(): ?Client
    {
        if ($this->isEmpty()) {
            return null;
        }

        return array_shift($this->queue);
    }

    public function peek(): ?Client
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->queue[0];
    }

    public function getAll(): array
    {
        return $this->queue;
    }

    public function isEmpty(): bool
    {
        return empty($this->queue);
    }
}
