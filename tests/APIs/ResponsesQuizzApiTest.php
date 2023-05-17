<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ResponsesQuizz;

class ResponsesQuizzApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_responses_quizz()
    {
        $responsesQuizz = ResponsesQuizz::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/responses_quizzs', $responsesQuizz
        );

        $this->assertApiResponse($responsesQuizz);
    }

    /**
     * @test
     */
    public function test_read_responses_quizz()
    {
        $responsesQuizz = ResponsesQuizz::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/responses_quizzs/'.$responsesQuizz->id
        );

        $this->assertApiResponse($responsesQuizz->toArray());
    }

    /**
     * @test
     */
    public function test_update_responses_quizz()
    {
        $responsesQuizz = ResponsesQuizz::factory()->create();
        $editedResponsesQuizz = ResponsesQuizz::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/responses_quizzs/'.$responsesQuizz->id,
            $editedResponsesQuizz
        );

        $this->assertApiResponse($editedResponsesQuizz);
    }

    /**
     * @test
     */
    public function test_delete_responses_quizz()
    {
        $responsesQuizz = ResponsesQuizz::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/responses_quizzs/'.$responsesQuizz->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/responses_quizzs/'.$responsesQuizz->id
        );

        $this->response->assertStatus(404);
    }
}
