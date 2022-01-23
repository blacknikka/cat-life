<?php

namespace App\Http\Resources\Feed;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @OA\Schema(
     *      schema="FeedResource",
     *      @OA\Property(format="int64", title="ID", description="ID", property="id", example=1),
     *      @OA\Property(format="string", title="served_at", description="served_at", property="served_at", example="2022-01-23 11:22:33"),
     *      @OA\Property(format="float", title="amount", description="amount", property="amount", example="50.11"),
     *      @OA\Property(format="string", title="memo", description="memo", property="memo", example="something you want to take a memo")
     * )
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "served_at" => $this->served_at,
            "amount" => $this->amount,
            "memo" => $this->memo,
        ];
    }
}
