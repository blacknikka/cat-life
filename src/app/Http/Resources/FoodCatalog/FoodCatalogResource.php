<?php

namespace App\Http\Resources\FoodCatalog;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodCatalogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @OA\Schema(
     *      schema="FoodCatalogResource",
     *      @OA\Property(
     *        property="id",
     *        format="number",
     *        example=1,
     *        description="food id",
     *      ),
     *      @OA\Property(
     *        property="name",
     *        format="string",
     *        example="food name",
     *        description="food name",
     *      ),
     *      @OA\Property(
     *        property="maker",
     *        format="string",
     *        example="maker name",
     *        description="maker name",
     *      ),
     *      @OA\Property(
     *        property="calorie",
     *        format="float",
     *        example=50.11,
     *        description="calorie",
     *      ),
     *      @OA\Property(
     *        property="memo",
     *        format="string",
     *        example="memo",
     *        description="memo",
     *      ),
     *      @OA\Property(
     *        property="url",
     *        format="string",
     *        example="https://example.com/product/1",
     *        description="url",
     *      ),
     * )
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "maker" => $this->maker,
            "calorie" => $this->calorie,
            "memo" => $this->memo,
            "url" => $this->url,
        ];
    }
}
