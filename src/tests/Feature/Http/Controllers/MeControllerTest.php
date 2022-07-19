<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Resources\MeResource;
use App\Models\FoodCatalog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MeControllerTest extends TestCase
{
    use RefreshDatabase;

    const API_BASE = "api/me";

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        // create necessary data.
        $this->user = User::factory()->create()->first();
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_me_正常系()
    {
        Sanctum::actingAs($this->user);

        $response = $this->get(self::API_BASE);
        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => (new MeResource($this->user))->resolve()
            ]);
    }

}
