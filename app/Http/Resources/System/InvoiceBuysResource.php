<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceBuysResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rep_debt_id' => $this->rep_debt_id,
            'seller_id' => $this->seller_id,
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'code' => $this->code,
            'box' => $this->box,
            'quantity_box' => $this->quantity_box,
            'quantity' => $this->quantity,
            'p_buy' => $this->p_buy,
            'p_buy_curr' => $this->p_buy_curr,
            'expense' => $this->expense,
            'expense_curr' => $this->expense_curr,
            'p_all_buy' => $this->p_all_buy,
            'p_all_buy_curr' => $this->p_all_buy_curr,
            'price_all' => $this->price_all,
            'price_all_curr' => $this->price_all_curr,
            'sell_ko' => $this->sell_ko,
            'sell_tak' => $this->sell_tak,
        ];
    }
}
