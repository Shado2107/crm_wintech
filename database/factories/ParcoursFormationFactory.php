<?php

namespace Database\Factories;

use App\Models\ParcoursFormation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParcoursFormationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ParcoursFormation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'libelle' => $this->faker->word,
        'description' => $this->faker->word,
        'prix' => $this->faker->randomDigitNotNull,
        'duree' => $this->faker->randomDigitNotNull,
        'formateur_id' => $this->faker->word,
        'parcours_transformation_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
