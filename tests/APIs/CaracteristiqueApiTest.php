<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Caracteristique;

class CaracteristiqueApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_caracteristique()
    {
        $caracteristique = Caracteristique::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/caracteristiques', $caracteristique
        );

        $this->assertApiResponse($caracteristique);
    }

    /**
     * @test
     */
    public function test_read_caracteristique()
    {
        $caracteristique = Caracteristique::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/caracteristiques/'.$caracteristique->id
        );

        $this->assertApiResponse($caracteristique->toArray());
    }

    /**
     * @test
     */
    public function test_update_caracteristique()
    {
        $caracteristique = Caracteristique::factory()->create();
        $editedCaracteristique = Caracteristique::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/caracteristiques/'.$caracteristique->id,
            $editedCaracteristique
        );

        $this->assertApiResponse($editedCaracteristique);
    }

    /**
     * @test
     */
    public function test_delete_caracteristique()
    {
        $caracteristique = Caracteristique::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/caracteristiques/'.$caracteristique->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/caracteristiques/'.$caracteristique->id
        );

        $this->response->assertStatus(404);
    }
}
