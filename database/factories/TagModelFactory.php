<?php

namespace Database\Factories;

use App\Models\TagModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagModelFactory extends Factory
{
    protected $model = TagModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'regex' => 'PAPA JOHNS|DOMINOS',
            'hex_code' => $this->faker->hexColor,
        ];
    }
}
