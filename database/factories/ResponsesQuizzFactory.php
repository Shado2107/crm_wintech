<?php

namespace Database\Factories;

use App\Models\ResponsesQuizz;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponsesQuizzFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResponsesQuizz::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'valeur' => $this->faker->word,
        'question_quizz_id' => $this->faker->word,
        'bonne_reponse' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
