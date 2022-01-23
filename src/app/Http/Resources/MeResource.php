<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @OA\Schema(
     *      schema="MeResource",
     *      @OA\Property(format="int64", title="ID", description="ID", property="id", example=1),
     *      @OA\Property(format="string", title="name", description="name", property="name", example="my name"),
     *      @OA\Property(format="string", title="email", description="email", property="email", example="user1@example.com")
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
