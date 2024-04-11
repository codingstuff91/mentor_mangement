<?php

namespace Tests\Factories;

class CustomerRequestDataFactory
{
    protected string $name = 'John Doe';

    public static function new(): self
    {
        return new self();
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function create(array $extra = []): array
    {
        return $extra + [
            'name' => $this->name,
            'comments' => 'Exemple de commentaires',
        ];
    }
}
