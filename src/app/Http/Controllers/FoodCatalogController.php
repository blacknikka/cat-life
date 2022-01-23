<?php

namespace App\Http\Controllers;

use App\Http\Resources\FoodCatalog\FoodCatalogResource;
use App\Models\FoodCatalog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', FoodCatalog::class);

        // do "index" is not allowed.
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/food_catalogs/",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         type="object",
     *         required={"name"},
     *         @OA\Property(
     *           property="name",
     *           format="string",
     *           example="food name",
     *           description="food name",
     *         ),
     *         @OA\Property(
     *           property="maker",
     *           format="string",
     *           example="maker name",
     *           description="maker name",
     *         ),
     *         @OA\Property(
     *           property="calorie",
     *           format="float",
     *           example=50.11,
     *           description="calorie",
     *         ),
     *         @OA\Property(
     *           property="memo",
     *           format="string",
     *           example="memo",
     *           description="memo",
     *         ),
     *         @OA\Property(
     *           property="url",
     *           format="string",
     *           example="https://example.com/product/1",
     *           description="url",
     *         ),
     *       )
     *     ),
     *     @OA\Response(response="200", description="create specified food catalog",@OA\JsonContent(ref="#/components/schemas/FoodCatalogResource")))
     * )
     */
    public function store(Request $request): FoodCatalogResource
    {
        $this->authorize('create', FoodCatalog::class);

        $foodCatalog = FoodCatalog::create(
            [
                "name" => $request->input("name"),
                "maker" => $request->input("maker") ?? "",
                "calorie" => $request->input("calorie") ?? 0,
                "memo" => $request->input("memo") ?? "",
                "url" => $request->input("url") ?? "",
                "is_master" => false,
                "user_id" => Auth::id(),
            ],
        );

        return new FoodCatalogResource($foodCatalog);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodCatalog  $foodCatalog
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/food_catalogs/{id}",
     *     @OA\Response(response="200", description="get specified food catalog",@OA\JsonContent(ref="#/components/schemas/FoodCatalogResource")))
     * )
     */
    public function show(FoodCatalog $foodCatalog): FoodCatalogResource
    {
        $this->authorize('view', $foodCatalog);

        return new FoodCatalogResource(FoodCatalog::find($foodCatalog->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodCatalog  $foodCatalog
     * @return \Illuminate\Http\Response
     * @OA\Patch(
     *     path="/api/food_catalogs/{id}",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         type="object",
     *         required={},
     *         @OA\Property(
     *           property="name",
     *           format="string",
     *           example="food name",
     *           description="food name",
     *         ),
     *         @OA\Property(
     *           property="maker",
     *           format="string",
     *           example="maker name",
     *           description="maker name",
     *         ),
     *         @OA\Property(
     *           property="calorie",
     *           format="float",
     *           example=50.11,
     *           description="calorie",
     *         ),
     *         @OA\Property(
     *           property="memo",
     *           format="string",
     *           example="memo",
     *           description="memo",
     *         ),
     *         @OA\Property(
     *           property="url",
     *           format="string",
     *           example="https://example.com/product/1",
     *           description="url",
     *         ),
     *       ),
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="update specified food catalog",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="status",
     *           format="boolean",
     *           example=true,
     *           description="updating succeeded or not",
     *         )
     *      )
     *    ),
     * )
     */
    public function update(Request $request, FoodCatalog $foodCatalog): JsonResponse
    {
        $this->authorize('update', $foodCatalog);

        $update = [];

        // name
        $update = array_merge($update,
            $request->has("name") ? [
                "name" => $request->input("name"),
            ] : []
        );

        // maker
        $update = array_merge($update,
            $request->has("maker") ? [
                "maker" => $request->input("maker"),
            ] : []
        );

        // calorie
        $update = array_merge($update,
            $request->has("calorie") ? [
                "calorie" => $request->input("calorie"),
            ] : []
        );

        // memo
        $update = array_merge($update,
            $request->has("memo") ? [
                "memo" => $request->input("memo"),
            ] : []
        );

        // url
        $update = array_merge($update,
            $request->has("url") ? [
                "url" => $request->input("url"),
            ] : []
        );

        $status = $foodCatalog->update($update);
        return new JsonResponse([
            "status" => $status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodCatalog  $foodCatalog
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/api/food_catalogs/{id}",
     *     @OA\Response(
     *      response="200",
     *      description="delete specified food catalogs",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="status",
     *           format="boolean",
     *           example=true,
     *           description="delete succeeded or not",
     *         )
     *      )
     *   )
     * )
     */
    public function destroy(FoodCatalog $foodCatalog): JsonResponse
    {
        $this->authorize('delete', $foodCatalog);

        $status = $foodCatalog->delete();

        return new JsonResponse([
            "status" => $status,
        ]);
    }
}
