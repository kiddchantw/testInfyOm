<?php namespace Tests\Repositories;

use App\Models\Shop;
use App\Repositories\ShopRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShopRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShopRepository
     */
    protected $shopRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shopRepo = \App::make(ShopRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shop()
    {
        $shop = Shop::factory()->make()->toArray();

        $createdShop = $this->shopRepo->create($shop);

        $createdShop = $createdShop->toArray();
        $this->assertArrayHasKey('id', $createdShop);
        $this->assertNotNull($createdShop['id'], 'Created Shop must have id specified');
        $this->assertNotNull(Shop::find($createdShop['id']), 'Shop with given id must be in DB');
        $this->assertModelData($shop, $createdShop);
    }

    /**
     * @test read
     */
    public function test_read_shop()
    {
        $shop = Shop::factory()->create();

        $dbShop = $this->shopRepo->find($shop->id);

        $dbShop = $dbShop->toArray();
        $this->assertModelData($shop->toArray(), $dbShop);
    }

    /**
     * @test update
     */
    public function test_update_shop()
    {
        $shop = Shop::factory()->create();
        $fakeShop = Shop::factory()->make()->toArray();

        $updatedShop = $this->shopRepo->update($fakeShop, $shop->id);

        $this->assertModelData($fakeShop, $updatedShop->toArray());
        $dbShop = $this->shopRepo->find($shop->id);
        $this->assertModelData($fakeShop, $dbShop->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shop()
    {
        $shop = Shop::factory()->create();

        $resp = $this->shopRepo->delete($shop->id);

        $this->assertTrue($resp);
        $this->assertNull(Shop::find($shop->id), 'Shop should not exist in DB');
    }
}
