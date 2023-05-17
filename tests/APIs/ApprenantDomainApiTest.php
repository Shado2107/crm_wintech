<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ApprenantDomain;

class ApprenantDomainApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_apprenant_domain()
    {
        $apprenantDomain = ApprenantDomain::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/apprenant_domains', $apprenantDomain
        );

        $this->assertApiResponse($apprenantDomain);
    }

    /**
     * @test
     */
    public function test_read_apprenant_domain()
    {
        $apprenantDomain = ApprenantDomain::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/apprenant_domains/'.$apprenantDomain->id
        );

        $this->assertApiResponse($apprenantDomain->toArray());
    }

    /**
     * @test
     */
    public function test_update_apprenant_domain()
    {
        $apprenantDomain = ApprenantDomain::factory()->create();
        $editedApprenantDomain = ApprenantDomain::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/apprenant_domains/'.$apprenantDomain->id,
            $editedApprenantDomain
        );

        $this->assertApiResponse($editedApprenantDomain);
    }

    /**
     * @test
     */
    public function test_delete_apprenant_domain()
    {
        $apprenantDomain = ApprenantDomain::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/apprenant_domains/'.$apprenantDomain->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/apprenant_domains/'.$apprenantDomain->id
        );

        $this->response->assertStatus(404);
    }
}
