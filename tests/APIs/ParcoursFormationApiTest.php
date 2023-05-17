<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ParcoursFormation;

class ParcoursFormationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_parcours_formation()
    {
        $parcoursFormation = ParcoursFormation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/parcours_formations', $parcoursFormation
        );

        $this->assertApiResponse($parcoursFormation);
    }

    /**
     * @test
     */
    public function test_read_parcours_formation()
    {
        $parcoursFormation = ParcoursFormation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/parcours_formations/'.$parcoursFormation->id
        );

        $this->assertApiResponse($parcoursFormation->toArray());
    }

    /**
     * @test
     */
    public function test_update_parcours_formation()
    {
        $parcoursFormation = ParcoursFormation::factory()->create();
        $editedParcoursFormation = ParcoursFormation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/parcours_formations/'.$parcoursFormation->id,
            $editedParcoursFormation
        );

        $this->assertApiResponse($editedParcoursFormation);
    }

    /**
     * @test
     */
    public function test_delete_parcours_formation()
    {
        $parcoursFormation = ParcoursFormation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/parcours_formations/'.$parcoursFormation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/parcours_formations/'.$parcoursFormation->id
        );

        $this->response->assertStatus(404);
    }
}
