<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Article;

class ArticleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_article()
    {
        $article = Article::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/articles', $article
        );

        $this->assertApiResponse($article);
    }

    /**
     * @test
     */
    public function test_read_article()
    {
        $article = Article::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/articles/'.$article->id
        );

        $this->assertApiResponse($article->toArray());
    }

    /**
     * @test
     */
    public function test_update_article()
    {
        $article = Article::factory()->create();
        $editedArticle = Article::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/articles/'.$article->id,
            $editedArticle
        );

        $this->assertApiResponse($editedArticle);
    }

    /**
     * @test
     */
    public function test_delete_article()
    {
        $article = Article::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/articles/'.$article->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/articles/'.$article->id
        );

        $this->response->assertStatus(404);
    }
}
