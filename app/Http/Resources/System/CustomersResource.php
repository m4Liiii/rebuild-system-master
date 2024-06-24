<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomersResource extends JsonResource
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
            'name_customer' => $this->name_customer,
            'debt_customer' => $this->debt_customer,
            'alert_of_debt' => $this->alert_of_debt,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'social_number' => $this->social_number,
            'notice' => $this->notice,
            'type_customer' => $this->type_customer,
            'type_delete' => $this->type_delete,
        ];
    }
}
