<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class AvatarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => 'Data Berhasil Disimpan!',
            'id' =>$this->id,
            'image' =>$this->image,
            'avatar_name' =>$this->avatar_name,
            // 'status' =>$this->status,
            'price' =>$this->price,
        ];
    }
}
