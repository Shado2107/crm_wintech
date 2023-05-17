<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ResponseUserChallenge;

class ResponseUserChallengeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_response_user_challenge()
    {
        $responseUserChallenge = ResponseUserChallenge::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/response_user_challenges', $responseUserChallenge
        );

        $this->assertApiResponse($responseUserChallenge);
    }

    /**
     * @test
     */
    public function test_read_response_user_challenge()
    {
        $responseUserChallenge = ResponseUserChallenge::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/response_user_challenges/'.$responseUserChallenge->id
        );

        $this->assertApiResponse($responseUserChallenge->toArray());
    }

    /**
     * @test
     */
    public function test_update_response_user_challenge()
    {
        $responseUserChallenge = ResponseUserChallenge::factory()->create();
        $editedResponseUserChallenge = ResponseUserChallenge::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/response_user_challenges/'.$responseUserChallenge->id,
            $editedResponseUserChallenge
        );

        $this->assertApiResponse($editedResponseUserChallenge);
    }

    /**
     * @test
     */
    public function test_delete_response_user_challenge()
    {
        $responseUserChallenge = ResponseUserChallenge::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/response_user_challenges/'.$responseUserChallenge->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/response_user_challenges/'.$responseUserChallenge->id
        );

        $this->response->assertStatus(404);
    }
}
