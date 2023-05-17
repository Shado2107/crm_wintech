<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Points;

class PointsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_points()
    {
        $points = Points::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/points', $points
        );

        $this->assertApiResponse($points);
    }

    /**
     * @test
     */
    public function test_read_points()
    {
        $points = Points::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/points/'.$points->id
        );

        $this->assertApiResponse($points->toArray());
    }

    /**
     * @test
     */
    public function test_update_points()
    {
        $points = Points::factory()->create();
        $editedPoints = Points::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/points/'.$points->id,
            $editedPoints
        );

        $this->assertApiResponse($editedPoints);
    }

    /**
     * @test
     */
    public function test_delete_points()
    {
        $points = Points::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/points/'.$points->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/points/'.$points->id
        );

        $this->response->assertStatus(404);
    }
}
