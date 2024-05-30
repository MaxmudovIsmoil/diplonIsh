<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderActionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "user" => $this->user->name,
            "plan" => $this->instance->name_ru,
            "status" => $this->status,
            "comment" => $this->comment,
            "created_at" => date('d.m.Y H:m', strtotime($this->created_at)),
            "updated_at" => date('d.m.Y H:m', strtotime($this->updated_at))
        ];
    }
}
