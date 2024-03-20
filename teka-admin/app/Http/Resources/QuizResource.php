<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'option1' => $this->option1,
            'option2' => $this->option2,
            'option3' => $this->option3
        ];
    }
}
