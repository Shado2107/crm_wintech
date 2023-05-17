<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\QuestionChallenge;

class QuestionChallengeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_question_challenge()
    {
        $questionChallenge = QuestionChallenge::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/question_challenges', $questionChallenge
        );

        $this->assertApiResponse($questionChallenge);
    }

    /**
     * @test
     */
    public function test_read_question_challenge()
    {
        $questionChallenge = QuestionChallenge::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/question_challenges/'.$questionChallenge->id
        );

        $this->assertApiResponse($questionChallenge->toArray());
    }

    /**
     * @test
     */
    public function test_update_question_challenge()
    {
        $questionChallenge = QuestionChallenge::factory()->create();
        $editedQuestionChallenge = QuestionChallenge::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/question_challenges/'.$questionChallenge->id,
            $editedQuestionChallenge
        );

        $this->assertApiResponse($editedQuestionChallenge);
    }

    /**
     * @test
     */
    public function test_delete_question_challenge()
    {
        $questionChallenge = QuestionChallenge::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/question_challenges/'.$questionChallenge->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/question_challenges/'.$questionChallenge->id
        );

        $this->response->assertStatus(404);
    }
}
