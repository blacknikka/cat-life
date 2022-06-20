<?php

namespace App\Http\Resources\Feed;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedListResource extends JsonResource
{
    public function __get( $name ) {
        return $this->resource[$name];
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "served_at" => $this->served_at,
            "amount" => $this->amount,
            "memo" => $this->memo,
            "food" => $this->food,
        ];
    }
}
