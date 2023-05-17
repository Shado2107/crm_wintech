<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Video;

class VideoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_video()
    {
        $video = Video::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/videos', $video
        );

        $this->assertApiResponse($video);
    }

    /**
     * @test
     */
    public function test_read_video()
    {
        $video = Video::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/videos/'.$video->id
        );

        $this->assertApiResponse($video->toArray());
    }

    /**
     * @test
     */
    public function test_update_video()
    {
        $video = Video::factory()->create();
        $editedVideo = Video::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/videos/'.$video->id,
            $editedVideo
        );

        $this->assertApiResponse($editedVideo);
    }

    /**
     * @test
     */
    public function test_delete_video()
    {
        $video = Video::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/videos/'.$video->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/videos/'.$video->id
        );

        $this->response->assertStatus(404);
    }
}
