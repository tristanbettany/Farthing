<?php

namespace Database\Factories;

use App\Models\TransactionModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionModelFactory extends Factory
{
    protected $model = TransactionModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'amount' => 10.99,
            'date' => $this->faker->dateTime,
            'running_total' => 10.99,
            'is_cashed' => $this->faker->boolean,
            'is_pending' => $this->faker->boolean,
            'is_future' => $this->faker->boolean,
        ];
    }
}
