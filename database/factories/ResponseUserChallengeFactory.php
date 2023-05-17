<?php

namespace Database\Factories;

use App\Models\ResponseUserChallenge;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseUserChallengeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResponseUserChallenge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'valeur' => $this->faker->word,
        'question_challenge_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
