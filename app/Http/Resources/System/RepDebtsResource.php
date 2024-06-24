<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use App\Http\Resources\System\UsersResource;
use App\Http\Resources\System\SellersResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RepDebtsResource extends JsonResource
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
            's_id' => $this->s_id,
            'seller_id' => $this->seller_id,
            'user_id' => $this->user_id,
            'office_id' => $this->office_id,
            'old_debt' => $this->old_debt,
            'amount_of_debt' => $this->amount_of_debt,
            'amount_curr' => $this->amount_curr,
            'new_debt' => $this->new_debt,
            'discount' => $this->discount,
            'discount_curr' => $this->discount_curr,
            'created_at' => $this->created_at,
            'type_amount' => $this-> type_amount,
            'type_delete' => $this->type_delete,
            'type_invoice' => $this->type_invoice,
            'type_notice' => $this->type_notice,
            'type_price' => $this->type_price,
            'curr' => $this->curr,
            'user' => new UsersResource($this->whenLoaded('user')),
            'seller' => new SellersResource($this->whenLoaded('seller')),
        ];
    }
}
