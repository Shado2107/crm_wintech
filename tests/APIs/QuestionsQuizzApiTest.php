<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\QuestionsQuizz;

class QuestionsQuizzApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_questions_quizz()
    {
        $questionsQuizz = QuestionsQuizz::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/questions_quizzs', $questionsQuizz
        );

        $this->assertApiResponse($questionsQuizz);
    }

    /**
     * @test
     */
    public function test_read_questions_quizz()
    {
        $questionsQuizz = QuestionsQuizz::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/questions_quizzs/'.$questionsQuizz->id
        );

        $this->assertApiResponse($questionsQuizz->toArray());
    }

    /**
     * @test
     */
    public function test_update_questions_quizz()
    {
        $questionsQuizz = QuestionsQuizz::factory()->create();
        $editedQuestionsQuizz = QuestionsQuizz::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/questions_quizzs/'.$questionsQuizz->id,
            $editedQuestionsQuizz
        );

        $this->assertApiResponse($editedQuestionsQuizz);
    }

    /**
     * @test
     */
    public function test_delete_questions_quizz()
    {
        $questionsQuizz = QuestionsQuizz::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/questions_quizzs/'.$questionsQuizz->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/questions_quizzs/'.$questionsQuizz->id
        );

        $this->response->assertStatus(404);
    }
}
