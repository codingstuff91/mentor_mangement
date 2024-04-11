<?php

namespace Tests\Factories;

class CustomerRequestDataFactory
{
    protected string $name = 'John Doe';
    protected string $comments = 'Example';

    public static function new(): self
    {
        return new self();
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function create(array $extra = []): array
    {
        return $extra + [
            'name' => $this->name,
            'comments' => $this->comments,
        ];
    }
}
