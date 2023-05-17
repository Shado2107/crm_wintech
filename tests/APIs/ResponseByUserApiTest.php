<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ResponseByUser;

class ResponseByUserApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_response_by_user()
    {
        $responseByUser = ResponseByUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/response_by_users', $responseByUser
        );

        $this->assertApiResponse($responseByUser);
    }

    /**
     * @test
     */
    public function test_read_response_by_user()
    {
        $responseByUser = ResponseByUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/response_by_users/'.$responseByUser->id
        );

        $this->assertApiResponse($responseByUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_response_by_user()
    {
        $responseByUser = ResponseByUser::factory()->create();
        $editedResponseByUser = ResponseByUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/response_by_users/'.$responseByUser->id,
            $editedResponseByUser
        );

        $this->assertApiResponse($editedResponseByUser);
    }

    /**
     * @test
     */
    public function test_delete_response_by_user()
    {
        $responseByUser = ResponseByUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/response_by_users/'.$responseByUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/response_by_users/'.$responseByUser->id
        );

        $this->response->assertStatus(404);
    }
}
