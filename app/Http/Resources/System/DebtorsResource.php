<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtorsResource extends JsonResource
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
            'name_debtor' => $this->name_debtor,
            'debt_debtor' => $this->debt_debtor,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'social_number' => $this->social_number,
            'notice' => $this->notice,
            'type_delete' => $this->type_delete,
        ];
    }
}
