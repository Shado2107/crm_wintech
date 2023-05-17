<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\challenge;

class challengeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_challenge()
    {
        $challenge = challenge::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/challenges', $challenge
        );

        $this->assertApiResponse($challenge);
    }

    /**
     * @test
     */
    public function test_read_challenge()
    {
        $challenge = challenge::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/challenges/'.$challenge->id
        );

        $this->assertApiResponse($challenge->toArray());
    }

    /**
     * @test
     */
    public function test_update_challenge()
    {
        $challenge = challenge::factory()->create();
        $editedchallenge = challenge::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/challenges/'.$challenge->id,
            $editedchallenge
        );

        $this->assertApiResponse($editedchallenge);
    }

    /**
     * @test
     */
    public function test_delete_challenge()
    {
        $challenge = challenge::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/challenges/'.$challenge->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/challenges/'.$challenge->id
        );

        $this->response->assertStatus(404);
    }
}
