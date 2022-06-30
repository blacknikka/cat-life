<?php

namespace Tests\Feature\CatController;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CatControllerTest extends TestCase
{
    use RefreshDatabase;

    private $xsrf_token = '';

    public function setUp(): void
    {
        parent::setUp();
        User::factory()->create();

    }

    /**
     * @test
     *
     * @return void
     */
    public function test_Catのcreate_without_picture()
    {
        $now = Carbon::now();

        $cat = [
            'name' => 'my-cat',
            'birth' =>  $now->toIso8601String(),
            'description' => 'description',
        ];

        Sanctum::actingAs($user = User::first());

        $response = $this->post('/api/cats', $cat);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => array_merge(
                    $cat,
                    [
                        'picture' => '',
                    ],
                )
            ]);

        $created = $response->json();

        $this->assertDatabaseHas('cats', [
            'id' => $created['data']['id'],
            'name' => $cat['name'],
            'birth' => $now->format('Y-m-d'),
            'user_id' => $user->id,
            'picture' => '',
        ]);
    }
}
