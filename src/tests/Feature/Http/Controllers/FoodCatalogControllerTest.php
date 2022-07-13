<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Resources\FoodCatalog\FoodCatalogResource;
use App\Models\FoodCatalog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FoodCatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    const API_BASE = "api/food_catalogs";

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
    public function test_index_異常系()
    {
        $response = $this->get(self::API_BASE);

        $response->assertStatus(302);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_store_正常系()
    {
        $contents = [
            "name" => "my-name",
            "maker" => "a maker",
            "calorie" => 123.4,
            "memo" => "my memo",
            "url" => "url",
        ];

        Sanctum::actingAs(User::first());

        $response = $this->post(self::API_BASE, $contents);
        $response
            ->assertStatus(201)
            ->assertJson([
                "data" => $contents
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_show_正常系()
    {
        $user = User::first();
        $foodCatalog = FoodCatalog::factory()->create([
            "user_id" => $user->id,
        ]);

        Sanctum::actingAs(User::first());

        $response = $this->get(self::API_BASE . "/$foodCatalog->id");
        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => (new FoodCatalogResource($foodCatalog))->resolve()
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_show_異常系_foodCatalog存在しない()
    {
        Sanctum::actingAs(User::first());

        $response = $this->get(self::API_BASE . "/0");
        $response
            ->assertStatus(404);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_update_正常系()
    {
        $user = User::first();
        $foodCatalog = FoodCatalog::factory()->create([
            "user_id" => $user->id,
        ]);

        Sanctum::actingAs(User::first());

        $this->assertDatabaseHas(
            "food_catalogs",
            array_merge(
                $foodCatalog->toArray(),
                [
                    "is_master" => $foodCatalog["is_master"] ? 1 : 0,
                    "created_at" => (new Carbon($foodCatalog["created_at"]))->toDateTimeString(),
                    "updated_at" => (new Carbon($foodCatalog["updated_at"]))->toDateTimeString(),
                ],
            ));

        $update = [
            "name" => "hoge",
            "maker" => "maker",
            "calorie" => 1234.5,
            "memo" => "my memo memo.",
            "url" => "url",
        ];
        $response = $this->patch(self::API_BASE . "/$foodCatalog->id", $update);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas("food_catalogs", $update);
    }
}
