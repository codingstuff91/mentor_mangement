<?php

namespace Tests\Factories;

use App\Models\Customer;
use App\Models\Subject;

class StudentRequestDataFactory
{
    protected string $name = 'test';
    protected string $goals = 'Learn PHP';

    public static function new(): self
    {
        return new self();
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withGoals(string $goals): self
    {
        $this->goals = $goals;

        return $this;
    }

    public function create(array $extra = []): array
    {
        return $extra + [
                'name' => $this->name,
                'subject' => Subject::first(),
                'active' => true,
                'customer' => Customer::first()->id,
                'goals' => $this->goals,
        ];
    }
}
