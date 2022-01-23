<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\MeResource;

class MeController extends Controller
{
    /**
     * @OA\Info(title="catlife API", version="0.1")
     * @OA\Get(
     *     path="/api/me",
     *     @OA\Response(response="200", description="success",@OA\JsonContent(ref="#/components/schemas/MeResource")))
     * )
     * @param Request $request
     * @return MeResource
     */
    public function __invoke(Request $request): MeResource
    {
        $user = $request->user();

        return new MeResource($user);
    }
}
