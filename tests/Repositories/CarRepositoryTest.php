<?php namespace Tests\Repositories;

use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CarRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarRepository
     */
    protected $carRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->carRepo = \App::make(CarRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_car()
    {
        $car = Car::factory()->make()->toArray();

        $createdCar = $this->carRepo->create($car);

        $createdCar = $createdCar->toArray();
        $this->assertArrayHasKey('id', $createdCar);
        $this->assertNotNull($createdCar['id'], 'Created Car must have id specified');
        $this->assertNotNull(Car::find($createdCar['id']), 'Car with given id must be in DB');
        $this->assertModelData($car, $createdCar);
    }

    /**
     * @test read
     */
    public function test_read_car()
    {
        $car = Car::factory()->create();

        $dbCar = $this->carRepo->find($car->id);

        $dbCar = $dbCar->toArray();
        $this->assertModelData($car->toArray(), $dbCar);
    }

    /**
     * @test update
     */
    public function test_update_car()
    {
        $car = Car::factory()->create();
        $fakeCar = Car::factory()->make()->toArray();

        $updatedCar = $this->carRepo->update($fakeCar, $car->id);

        $this->assertModelData($fakeCar, $updatedCar->toArray());
        $dbCar = $this->carRepo->find($car->id);
        $this->assertModelData($fakeCar, $dbCar->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_car()
    {
        $car = Car::factory()->create();

        $resp = $this->carRepo->delete($car->id);

        $this->assertTrue($resp);
        $this->assertNull(Car::find($car->id), 'Car should not exist in DB');
    }
}
