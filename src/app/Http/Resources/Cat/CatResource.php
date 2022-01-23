<?php

namespace App\Http\Resources\Cat;

use Illuminate\Http\Resources\Json\JsonResource;

class CatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @OA\Schema(
     *      schema="CatResource",
     *      @OA\Property(format="int64", title="ID", description="ID", property="id", example=1),
     *      @OA\Property(format="string", title="name", description="name", property="name", example="cat name"),
     *      @OA\Property(format="string", title="birth", description="birthday string", property="birth", example="2022-01-23"),
     *      @OA\Property(format="string", title="description", description="description", property="description", example="something you want to take a memo")
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birth' => $this->birth,
            'description' => $this->description,
        ];
    }
}
