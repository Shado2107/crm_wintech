<?php

namespace Database\Factories;

use App\Models\ApprenantDomain;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApprenantDomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApprenantDomain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'apprenant_id' => $this->faker->word,
        'domain_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
