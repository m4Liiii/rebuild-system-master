<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use App\Http\Resources\System\UsersResource;
use App\Http\Resources\System\CustomersResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetDebtsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalPrice = $this->invoices->sum('price_all');
        $totalProfit = $this->invoices->sum('profit');
        return[
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'old_debt' => $this->old_debt,
            'delivery' => $this->delivery,
            'user' => new UsersResource($this->whenLoaded('user')),
            'amount_of_debt' => $this->amount_of_debt,
            'new_debt' => $this->new_debt,
            'discount' => $this->discount,
            'created_at' => $this->created_at,
            'type_amount' => $this-> type_amount,
            'amount_dollar' => $this-> amount_dollar,
            'amount_dinar' => $this-> amount_dinar,
            'type_delete' => $this->type_delete,
            'type_invoice' => $this->type_invoice,
            'type_notice' => $this->type_notice,
            's_id' => $this->s_id,
            'total_price' => $totalPrice,
            'total_profit' => $totalProfit,
            'customer' => new CustomersResource($this->whenLoaded('customer')),
        ];
    }
}
