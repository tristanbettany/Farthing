<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateModelFactory extends Factory
{
    protected $model = Template::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'amount' => 10.99,
            'occurances' => $this->faker->randomNumber(1),
            'occurance_syntax' => '@weekly',
            'is_active' => true,
        ];
    }
}
