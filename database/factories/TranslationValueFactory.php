<?php

namespace Database\Factories;

use App\Models\TranslationValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationValueFactory extends Factory
{
    protected $model = TranslationValue::class;

    public function definition(): array
    {
        return [
            'locale' => $this->faker->randomElement(['en', 'fr', 'es', 'de', 'ur']),
            'value'  => $this->faker->sentence(3),
        ];
    }
}