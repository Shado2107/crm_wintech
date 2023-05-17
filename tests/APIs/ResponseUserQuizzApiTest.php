<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ResponseUserQuizz;

class ResponseUserQuizzApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_response_user_quizz()
    {
        $responseUserQuizz = ResponseUserQuizz::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/response_user_quizzs', $responseUserQuizz
        );

        $this->assertApiResponse($responseUserQuizz);
    }

    /**
     * @test
     */
    public function test_read_response_user_quizz()
    {
        $responseUserQuizz = ResponseUserQuizz::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/response_user_quizzs/'.$responseUserQuizz->id
        );

        $this->assertApiResponse($responseUserQuizz->toArray());
    }

    /**
     * @test
     */
    public function test_update_response_user_quizz()
    {
        $responseUserQuizz = ResponseUserQuizz::factory()->create();
        $editedResponseUserQuizz = ResponseUserQuizz::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/response_user_quizzs/'.$responseUserQuizz->id,
            $editedResponseUserQuizz
        );

        $this->assertApiResponse($editedResponseUserQuizz);
    }

    /**
     * @test
     */
    public function test_delete_response_user_quizz()
    {
        $responseUserQuizz = ResponseUserQuizz::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/response_user_quizzs/'.$responseUserQuizz->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/response_user_quizzs/'.$responseUserQuizz->id
        );

        $this->response->assertStatus(404);
    }
}
