<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Citation;

class CitationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_citation()
    {
        $citation = Citation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/citations', $citation
        );

        $this->assertApiResponse($citation);
    }

    /**
     * @test
     */
    public function test_read_citation()
    {
        $citation = Citation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/citations/'.$citation->id
        );

        $this->assertApiResponse($citation->toArray());
    }

    /**
     * @test
     */
    public function test_update_citation()
    {
        $citation = Citation::factory()->create();
        $editedCitation = Citation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/citations/'.$citation->id,
            $editedCitation
        );

        $this->assertApiResponse($editedCitation);
    }

    /**
     * @test
     */
    public function test_delete_citation()
    {
        $citation = Citation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/citations/'.$citation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/citations/'.$citation->id
        );

        $this->response->assertStatus(404);
    }
}
