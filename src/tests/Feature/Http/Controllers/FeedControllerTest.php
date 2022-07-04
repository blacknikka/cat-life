<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FeedController;
use App\Models\Feed;
use App\Models\FoodCatalog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FeedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // create necessary data.
        User::factory()->create();
        FoodCatalog::factory()->create();
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_store_正常系()
    {
        $now = Carbon::createFromTime();
        $feed = [
            'served_at' => $now->toJSON(),
            'amount' => 10,
            'memo' => 'my memo',
            'food_id' => (FoodCatalog::first())->id,
        ];

        Sanctum::actingAs(User::first());

        $response = $this->post('/api/feeds', $feed);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'served_at' => $now->utc()->toJSON(),
                    'amount' => $feed['amount'],
                    'memo' => $feed['memo'],
                ],
            ]);

        $created = $response->json();

        $this->assertDatabaseHas('feeds', [
            'id' => $created['data']['id'],
            'served_at' => $now->utc()->toJSON(),
            'amount' => $feed['amount'],
            'memo' => $feed['memo'],
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_store_異常系_FoodCatalogが存在しない()
    {
        $now = Carbon::createFromTime();
        $feed = [
            'served_at' => $now->toJSON(),
            'amount' => 10,
            'memo' => 'my memo',

            // 存在しないIDを指定
            'food_id' => (FoodCatalog::first())->id + 1,
        ];

        Sanctum::actingAs(User::first());

        $response = $this->post('/api/feeds', $feed);

        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => FeedController::FOODCATALOG_NOT_FOUND_MESSAGE,
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_show_正常系()
    {
        $feed = Feed::factory()->who(User::first()->id)->create();

        Sanctum::actingAs(User::first());

        $response = $this->get("/api/feeds/{$feed->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $feed->id,
                ],
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_show_異常系_Feedが存在しない()
    {
        Sanctum::actingAs(User::first());

        // 適当なIDを指定
        $response = $this->get("/api/feeds/1000");

        $response
            ->assertStatus(404);
    }
}
