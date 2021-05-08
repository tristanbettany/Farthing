<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountModelFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'account_number' => $this->faker->bankAccountNumber,
            'sort_code' => $this->faker->bankAccountNumber,
            'name' => $this->faker->firstName . 's Account',
        ];
    }
}
