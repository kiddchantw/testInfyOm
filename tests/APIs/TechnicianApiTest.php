<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Technician;

class TechnicianApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_technician()
    {
        $technician = Technician::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/technicians', $technician
        );

        $this->assertApiResponse($technician);
    }

    /**
     * @test
     */
    public function test_read_technician()
    {
        $technician = Technician::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/technicians/'.$technician->id
        );

        $this->assertApiResponse($technician->toArray());
    }

    /**
     * @test
     */
    public function test_update_technician()
    {
        $technician = Technician::factory()->create();
        $editedTechnician = Technician::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/technicians/'.$technician->id,
            $editedTechnician
        );

        $this->assertApiResponse($editedTechnician);
    }

    /**
     * @test
     */
    public function test_delete_technician()
    {
        $technician = Technician::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/technicians/'.$technician->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/technicians/'.$technician->id
        );

        $this->response->assertStatus(404);
    }
}
