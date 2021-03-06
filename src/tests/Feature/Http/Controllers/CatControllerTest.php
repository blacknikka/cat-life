<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Cat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CatControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Cat $cat;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create()->first();
        $this->cat = Cat::factory()->create([
            "user_id" => $this->user->id,
        ])->first();
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_Catのstore_without_picture_正常系()
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
    public function test_Catのstore_with_picture_正常系()
    {
        $now = Carbon::now();

        $image = UploadedFile::fake()->image('cat.jpeg');
        $base64 = 'data:image/jpg;base64,' . base64_encode(file_get_contents($image));

        $cat = [
            'name' => 'my-cat',
            'birth' =>  $now->toIso8601String(),
            'description' => 'description',
        ];

        Sanctum::actingAs($this->user);

        $response = $this->post('/api/cats', array_merge(
            $cat,
            [
                'image' =>  $base64,
            ]),
        );

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => array_merge(
                    $cat,
                    [
                        'picture' => $base64,
                    ],
                )
            ]);

        $created = $response->json();

        $this->assertDatabaseHas('cats', [
            'id' => $created['data']['id'],
            'name' => $cat['name'],
            'birth' => $now->format('Y-m-d'),
            'user_id' => $this->user->id,
        ]);

        $this->assertNotEmpty(Cat::find($created['data']['id'])->picture);
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

        $cats = collect([$this->cat])->concat($cats);

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

    /**
     * @test
     *
     * @return void
     */
    public function test_Catのupdate_without_picture_正常系()
    {
        $user = User::first();

        Sanctum::actingAs($user);
        $cats = Cat::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $updateWith = [
            "name" => "xyz",
            "birth" => (Carbon::tomorrow())->toIso8601String(),
            "description" => "updated",
        ];
        $updateResponse = $this->patch("/api/cats/{$cats[0]->id}", $updateWith);

        $updateResponse
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
            ]);

        $this->assertDatabaseHas('cats', [
            'id' => $cats[0]->id,
            'name' => $updateWith["name"],
            'birth' => $updateWith["birth"],
            'user_id' => $user->id,
            'picture' => '',
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_Catのdestroy_正常系()
    {
        $user = User::first();

        Sanctum::actingAs($user);
        $cats = Cat::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $target = ($this->get("/api/cats/{$cats[0]->id}"))->json();

        $response = $this->delete("/api/cats/{$cats[0]->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                "status" => true,
            ]);

        $this->assertDatabaseMissing('cats', [
            'id' => $cats[0]->id,
            'name' => $target["data"]["name"],
            'birth' => $target["data"]["birth"],
            'description' => $target["data"]["description"],
            'user_id' => $user->id,
            'picture' => '',
        ]);
    }
}
