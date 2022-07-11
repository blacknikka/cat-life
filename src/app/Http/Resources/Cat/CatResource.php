<?php

namespace App\Http\Resources\Cat;

use App\Services\S3Service;
use Carbon\Carbon;
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
     *      @OA\Property(format="string", title="description", description="description", property="description", example="something you want to take a memo"),
     *      @OA\Property(format="string", title="picture", description="picture which is encoded with base64 format", property="picture", example="hogehoge"),
     * )
     */
    public function toArray($request)
    {
        $picture = '';

        if ($this->picture !== "") {
            $s3service = new S3Service();
            $picture = $s3service->GetAFile($this->picture);

            // get extension
            $extension = pathinfo($this->picture, PATHINFO_EXTENSION);
            if ($picture)
            {
                $picture = base64_encode($picture);
                $picture = "data:image/{$extension};base64," . $picture;
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'birth' => (new Carbon($this->birth))->toIso8601String(),
            'description' => $this->description,
            'picture' => $picture,
        ];
    }
}
