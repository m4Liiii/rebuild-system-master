<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellersResource extends JsonResource
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
            'name_seller' => $this->name_seller,
            'debt_seller' => $this->debt_seller,
            'alert_of_debt' => $this->alert_of_debt,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'social_number' => $this->social_number,
            'notice' => $this->notice,
            'type_curr' => $this->type_curr,
            'type_delete' => $this->type_delete,
        ];
    }
}
