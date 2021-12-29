<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Shop;

class ShopApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shop()
    {
        $shop = Shop::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/shops', $shop
        );

        $this->assertApiResponse($shop);
    }

    /**
     * @test
     */
    public function test_read_shop()
    {
        $shop = Shop::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/shops/'.$shop->id
        );

        $this->assertApiResponse($shop->toArray());
    }

    /**
     * @test
     */
    public function test_update_shop()
    {
        $shop = Shop::factory()->create();
        $editedShop = Shop::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/shops/'.$shop->id,
            $editedShop
        );

        $this->assertApiResponse($editedShop);
    }

    /**
     * @test
     */
    public function test_delete_shop()
    {
        $shop = Shop::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/shops/'.$shop->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/shops/'.$shop->id
        );

        $this->response->assertStatus(404);
    }
}
