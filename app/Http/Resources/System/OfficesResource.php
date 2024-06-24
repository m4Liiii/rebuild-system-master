<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficesResource extends JsonResource
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
            'name_office' => $this->name_office,
            'debt_office' => $this->debt_office,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'social_number' => $this->social_number,
            'notice' => $this->notice,
            'type_delete' => $this->type_delete,
        ];
    }
}
