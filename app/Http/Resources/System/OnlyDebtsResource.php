<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use App\Http\Resources\System\UsersResource;
use App\Http\Resources\System\DebtorsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OnlyDebtsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'debtor_id' => $this->debtor_id,
            'user_id' => $this->user_id,
            'old_debt' => $this->old_debt,
            'user' => new UsersResource($this->whenLoaded('user')),
            'amount_of_debt' => $this->amount_of_debt,
            'new_debt' => $this->new_debt,
            'discount' => $this->discount,
            'created_at' => $this->created_at,
            'type_delete' => $this->type_delete,
            'notice_of_debt' => $this->notice_of_debt,
            'name_of_recipient' => $this->name_of_recipient,
            'debtor' => new DebtorsResource($this->whenLoaded('debtor')),
        ];
    }
}
