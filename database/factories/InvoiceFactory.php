<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'paid' => $this->faker->boolean,
        ];
    }

    /**
     * Indicate that the invoice is unpaid.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unpaid()
    {
        return $this->state(function (array $attributes) {
            return [
                'paid' => false,
            ];
        });
    }

    /**
     * Indicate that the invoice is paid.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'paid' => true,
            ];
        });
    }
}
