<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\RoueVie;

class RoueVieApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_roue_vie()
    {
        $roueVie = RoueVie::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/roue_vies', $roueVie
        );

        $this->assertApiResponse($roueVie);
    }

    /**
     * @test
     */
    public function test_read_roue_vie()
    {
        $roueVie = RoueVie::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/roue_vies/'.$roueVie->id
        );

        $this->assertApiResponse($roueVie->toArray());
    }

    /**
     * @test
     */
    public function test_update_roue_vie()
    {
        $roueVie = RoueVie::factory()->create();
        $editedRoueVie = RoueVie::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/roue_vies/'.$roueVie->id,
            $editedRoueVie
        );

        $this->assertApiResponse($editedRoueVie);
    }

    /**
     * @test
     */
    public function test_delete_roue_vie()
    {
        $roueVie = RoueVie::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/roue_vies/'.$roueVie->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/roue_vies/'.$roueVie->id
        );

        $this->response->assertStatus(404);
    }
}
