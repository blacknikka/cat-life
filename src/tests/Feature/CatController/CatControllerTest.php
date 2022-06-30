<?php

namespace Tests\Feature\CatController;

use App\Models\Cat;
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
    public function test_Catのcreate_without_picture_正常系()
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

    /**
     * @test
     *
     * @return void
     */
    public function test_Catのindex_list取得_正常系()
    {
        $user = User::first();
        Sanctum::actingAs($user);
        $cats = Cat::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('/api/cats');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => $cats->map(function($cat) {
                    return [
                        'id' => $cat->id,
                        'name' => $cat->name,
                        'birth' => (new Carbon($cat->birth))->toIso8601String(),
                        'description' => $cat->description,
                        'picture' => '',
                    ];
                })->toArray(),
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_Catのshow_index指定_正常系()
    {
        $user = User::first();
        $anotherUser = User::factory()->create();

        Sanctum::actingAs($user);
        $cats = Cat::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        Cat::factory()->count(3)->create([
            'user_id' => $anotherUser->id,
        ]);

        $response = $this->get("/api/cats/{$cats[0]->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $cats[0]->id,
                    'name' => $cats[0]->name,
                    'birth' => (new Carbon($cats[0]->birth))->toIso8601String(),
                    'description' => $cats[0]->description,
                    'picture' => '',
                ],
            ]);
    }
}
