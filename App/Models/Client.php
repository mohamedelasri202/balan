<?php

namespace App\Models;


class Client
{
    private string $firstName;
    private string $order;

    public function __construct(string $firstName, string $order)
    {
        $this->firstName = $firstName;
        $this->order = $order;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function __toString(): string
    {
        return "{$this->firstName} veut {$this->order}";
    }
}
