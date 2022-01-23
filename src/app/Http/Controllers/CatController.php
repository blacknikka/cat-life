<?php

namespace App\Http\Controllers;

use App\Http\Resources\Cat\CatResource;
use App\Http\Resources\Cat\CatUpdateResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Cat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Cat::class);

        // do "index" is not allowed.
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/cats/",
     *     @OA\RequestBody(
     *          required=true,
     *       @OA\JsonContent(
     *         type="object",
     *         required={"name", "birth", "description"},
     *          @OA\Property(
     *              property="name",
     *              type="string",
     *              example="cat name",
     *              description="cat name"
     *          ),
     *          @OA\Property(
     *              property="birth",
     *              type="string",
     *              example="2022-01-23 11:22:33",
     *              description="cat's birthday"
     *          ),
     *          @OA\Property(
     *              property="description",
     *              type="string",
     *              example="something you want to take a memo",
     *              description="cat's description"
     *          )
     *       )
     *     ),
     *     @OA\Response(response="200", description="create specified cat",@OA\JsonContent(ref="#/components/schemas/CatResource")))
     * )
     */
    public function store(Request $request): CatResource
    {
        $this->authorize('create', Cat::class);

        $cat = Cat::create(
            [
                "name" => $request->input("name"),
                "birth" => new Carbon($request->input("birth")),
                "description" => $request->input("description"),
                "user_id" => Auth::id(),
            ],
        );

        return new CatResource($cat);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/cats/{id}",
     *     @OA\Response(response="200", description="get specified cat",@OA\JsonContent(ref="#/components/schemas/CatResource")))
     * )
     */
    public function show(Cat $cat): CatResource
    {
        $this->authorize('view', $cat);

        return new CatResource(Cat::find($cat->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @OA\Patch(
     *     path="/api/cats/{id}",
     *     @OA\Response(
     *      response="200",
     *      description="update specified cat",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="status",
     *           format="boolean",
     *           example=true,
     *           description="updating succeeded or not",
     *         )
     *      )
     *   )
     * )
     */
    public function update(Request $request, Cat $cat): JsonResponse
    {
        $this->authorize('update', $cat);

        $status = $cat->update([
            "name" => $request->input("name"),
            "birth" => new Carbon($request->input("birth")),
            "description" => $request->input("description"),
            "user_id" => Auth::id(),
        ]);

        return new JsonResponse([
            "status" => $status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/api/cats/{id}",
     *     @OA\Response(
     *      response="200",
     *      description="delete specified cat",
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
    public function destroy(Cat $cat): JsonResponse
    {
        $this->authorize('delete', $cat);

        $status = $cat->delete();

        return new JsonResponse([
            "status" => $status,
        ]);
    }
}