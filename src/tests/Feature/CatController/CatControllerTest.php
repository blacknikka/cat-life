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
        $user = User::factory()->create();

    }

    /**
     * @test
     *
     * @return void
     */
    public function test_Catのcreate_without_picture()
    {
        $cat = [
            'name' => 'my-cat',
            'birth' =>  (Carbon::now())->toIso8601String(),
            'description' => 'description',
        ];

        // skip auth process
//        $this->withoutAuthorization();

        Sanctum::actingAs(User::first());

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
    }
}
