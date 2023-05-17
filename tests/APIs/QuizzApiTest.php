<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Quizz;

class QuizzApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_quizz()
    {
        $quizz = Quizz::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/quizzs', $quizz
        );

        $this->assertApiResponse($quizz);
    }

    /**
     * @test
     */
    public function test_read_quizz()
    {
        $quizz = Quizz::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/quizzs/'.$quizz->id
        );

        $this->assertApiResponse($quizz->toArray());
    }

    /**
     * @test
     */
    public function test_update_quizz()
    {
        $quizz = Quizz::factory()->create();
        $editedQuizz = Quizz::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/quizzs/'.$quizz->id,
            $editedQuizz
        );

        $this->assertApiResponse($editedQuizz);
    }

    /**
     * @test
     */
    public function test_delete_quizz()
    {
        $quizz = Quizz::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/quizzs/'.$quizz->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/quizzs/'.$quizz->id
        );

        $this->response->assertStatus(404);
    }
}
