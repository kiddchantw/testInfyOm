<?php namespace Tests\Repositories;

use App\Models\Technician;
use App\Repositories\TechnicianRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TechnicianRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TechnicianRepository
     */
    protected $technicianRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->technicianRepo = \App::make(TechnicianRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_technician()
    {
        $technician = Technician::factory()->make()->toArray();

        $createdTechnician = $this->technicianRepo->create($technician);

        $createdTechnician = $createdTechnician->toArray();
        $this->assertArrayHasKey('id', $createdTechnician);
        $this->assertNotNull($createdTechnician['id'], 'Created Technician must have id specified');
        $this->assertNotNull(Technician::find($createdTechnician['id']), 'Technician with given id must be in DB');
        $this->assertModelData($technician, $createdTechnician);
    }

    /**
     * @test read
     */
    public function test_read_technician()
    {
        $technician = Technician::factory()->create();

        $dbTechnician = $this->technicianRepo->find($technician->id);

        $dbTechnician = $dbTechnician->toArray();
        $this->assertModelData($technician->toArray(), $dbTechnician);
    }

    /**
     * @test update
     */
    public function test_update_technician()
    {
        $technician = Technician::factory()->create();
        $fakeTechnician = Technician::factory()->make()->toArray();

        $updatedTechnician = $this->technicianRepo->update($fakeTechnician, $technician->id);

        $this->assertModelData($fakeTechnician, $updatedTechnician->toArray());
        $dbTechnician = $this->technicianRepo->find($technician->id);
        $this->assertModelData($fakeTechnician, $dbTechnician->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_technician()
    {
        $technician = Technician::factory()->create();

        $resp = $this->technicianRepo->delete($technician->id);

        $this->assertTrue($resp);
        $this->assertNull(Technician::find($technician->id), 'Technician should not exist in DB');
    }
}
