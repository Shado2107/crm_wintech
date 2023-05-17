<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Commentaire;

class CommentaireApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_commentaire()
    {
        $commentaire = Commentaire::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/commentaires', $commentaire
        );

        $this->assertApiResponse($commentaire);
    }

    /**
     * @test
     */
    public function test_read_commentaire()
    {
        $commentaire = Commentaire::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/commentaires/'.$commentaire->id
        );

        $this->assertApiResponse($commentaire->toArray());
    }

    /**
     * @test
     */
    public function test_update_commentaire()
    {
        $commentaire = Commentaire::factory()->create();
        $editedCommentaire = Commentaire::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/commentaires/'.$commentaire->id,
            $editedCommentaire
        );

        $this->assertApiResponse($editedCommentaire);
    }

    /**
     * @test
     */
    public function test_delete_commentaire()
    {
        $commentaire = Commentaire::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/commentaires/'.$commentaire->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/commentaires/'.$commentaire->id
        );

        $this->response->assertStatus(404);
    }
}
