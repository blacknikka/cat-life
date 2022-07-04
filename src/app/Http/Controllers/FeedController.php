<?php

namespace App\Http\Controllers;

use App\Http\Resources\Feed\FeedListResource;
use App\Http\Resources\Feed\FeedResource;
use App\Models\Feed;
use App\Models\Cat;
use App\Models\FoodCatalog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    const FOODCATALOG_NOT_FOUND_MESSAGE = "food_id not found";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Feed::class);

        // do "index" is not allowed.
        return new JsonResponse([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function feeds($id) : Collection
    {
        $user = Auth::user();
        $feeds = Feed::with(['food', 'cat'])
            ->whereHas('cat', fn ($q) => $q->where('user_id' ,$user->id))
            ->where('cat_id', $id)
            ->get();

        return $feeds
            ->map(function ($f) {
                return new FeedListResource(array_merge(
                    $f->toArray(),
                    [
                        'food' => [
                            'id' => $f->food->id,
                            'name' => $f->food->name,
                            'maker' => $f->food->maker,
                            'calorie' => $f->food->calorie,
                            'memo' => $f->food->memo,
                            'picture' => $f->food->picture,
                            'url' => $f->food->url
                        ],
                    ],
                ));
            });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/feeds/",
     *     @OA\RequestBody(
     *          required=true,
     *       @OA\JsonContent(
     *         type="object",
     *         required={"served_at", "amount", "memo", "food_id"},
     *          @OA\Property(
     *              property="served_at",
     *              type="string",
     *              example="2022-01-23 11:22:33",
     *              description="served at"
     *          ),
     *          @OA\Property(
     *              property="amount",
     *              type="float",
     *              example=50.11,
     *              description="amount"
     *          ),
     *          @OA\Property(
     *              property="memo",
     *              type="string",
     *              example="something you want to take a memo",
     *              description="memo"
     *          ),
     *          @OA\Property(
     *              property="food_id",
     *              type="number",
     *              example=1,
     *              description="food id"
     *          )
     *       )
     *     ),
     *     @OA\Response(response="200", description="create specified feed",@OA\JsonContent(ref="#/components/schemas/FeedResource")))
     * @OA\Response(
     *      response="400",
     *      description="failed to create",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="message",
     *           format="string",
     *           example="error message",
     *           description="error message",
     *         )
     *      )
     *   )
     * )
     */
    public function store(Request $request): FeedResource|JsonResponse
    {
        $this->authorize('create', Feed::class);

        $foodId = $request->input("food_id");

        try {
            $food = FoodCatalog::findOrFail($foodId);
            $feed = Feed::create(
                [
                    "served_at" => new Carbon($request->input("served_at")),
                    "amount" => $request->input("amount"),
                    "memo" => $request->input("memo"),
                    "user_id" => Auth::id(),
                    "food_id" => $food->id,
                ],
            );
            return new FeedResource($feed);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse([
                "message" => self::FOODCATALOG_NOT_FOUND_MESSAGE,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Feed $feed
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/feeds/{id}",
     *     @OA\Response(response="200", description="get specified feed",@OA\JsonContent(ref="#/components/schemas/FeedResource")),
     *     @OA\Response(
     *      response="400",
     *      description="not found",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="message",
     *           format="string",
     *           example="not found",
     *           description="not found error",
     *         )
     *      )
     *    ),
     *   )
     * )
     */
    public function show(Feed $feed): FeedResource|JsonResponse
    {
        $this->authorize('view', $feed);

        try {
            return new FeedResource(Feed::find($feed->id));
        } catch (ModelNotFoundException $e) {
            return new JsonResponse([
                "message" => "feed not found",
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feed $feed
     * @return \Illuminate\Http\Response
     * @OA\Patch(
     *     path="/api/feeds/{id}",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         type="object",
     *         required={},
     *          @OA\Property(
     *              property="food_id",
     *              type="number",
     *              example=1,
     *              description="food id"
     *          ),
     *          @OA\Property(
     *              property="served_at",
     *              type="string",
     *              example="2022-01-23 11:22:33",
     *              description="served at"
     *          ),
     *          @OA\Property(
     *              property="amount",
     *              type="number",
     *              example=50.11,
     *              description="amount"
     *          ),
     *          @OA\Property(
     *              property="memo",
     *              type="string",
     *              example="memo",
     *              description="memo"
     *          ),
     *       ),
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="update specified feed",
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
     *     @OA\Response(
     *      response="400",
     *      description="not found",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="message",
     *           format="string",
     *           example="not found",
     *           description="not found error",
     *         )
     *      )
     *    ),
     * )
     */
    public function update(Request $request, Feed $feed): FeedResource|JsonResponse
    {
        $this->authorize('update', $feed);

        $update = [];

        // confirm food_id
        if ($request->has("food_id")) {
            $foodId = $request->input("food_id");
            try {
                $food = FoodCatalog::findOrFail($foodId);
                $update = array_merge($update, [
                    "food_id" => $food->id,
                ]);
            } catch (ModelNotFoundException $e) {
                return new JsonResponse([
                    "message" => "food_id not found",
                ], 400);
            }
        }

        // served_at
        $update = array_merge($update,
            $request->has("served_at") ? [
                "served_at" => new Carbon($request->input("served_at")),
            ] : []
        );

        // amount
        $update = array_merge($update,
            $request->has("amount") ? [
                "amount" => $request->input("amount"),
            ] : []
        );

        // memo
        $update = array_merge($update,
            $request->has("memo") ? [
                "memo" => $request->input("memo"),
            ] : []
        );

        $status = $feed->update($update);
        return new JsonResponse([
            "status" => $status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Feed $feed
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/api/feeds/{id}",
     *     @OA\Response(
     *      response="200",
     *      description="delete specified feed",
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
    public function destroy(Feed $feed): JsonResponse
    {
        $this->authorize('delete', $feed);

        $status = $feed->delete();

        return new JsonResponse([
            "status" => $status,
        ]);
    }
}
