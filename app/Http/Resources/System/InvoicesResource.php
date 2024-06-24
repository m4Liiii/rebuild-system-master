<?php

namespace App\Http\Resources\System;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lastInvoice = Invoice::where('customer_id', $this->customer_id)
            ->where('product_id', $this->product_id)
            ->orderBy('id', 'desc')
            ->skip(1)
            ->first(['price', 'get_debt_id']);

        // Check if product relationship is loaded and not null
        $priceOfBuy = $this->product ? $this->product->price_of_buy : null;
        $priceOfSellKo = $this->product ? $this->product->price_of_sell_ko : null;
        $priceOfSellTak = $this->product ? $this->product->price_of_sell_tak : null;

        return [
            'id' => $this->id,
            'get_debt_id' => $this->get_debt_id,
            'customer_id' => $this->customer_id,
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'code' => $this->code,
            'box' => $this->box,
            'created_at' => $this->created_at,
            'quantity_box' => $this->quantity_box,
            'quantity' => $this->quantity,
            'profit' => $this->profit,
            'price' => $this->price,
            'price_all' => $this->price_all,
            'price_of_buy' => $priceOfBuy,
            'price_of_sell_ko' => $priceOfSellKo,
            'price_of_sell_tak' => $priceOfSellTak,
            'last_price' => $lastInvoice?->price,
            'last_get_debt_id' => $lastInvoice?->get_debt_id,
            'user' => new UsersResource($this->whenLoaded('user')),
            'getDebt' => $this->whenLoaded('getDebt', function () {
                return [
                    's_id' => $this->getDebt->s_id,
                    'type_delete' => $this->getDebt->type_delete
                ];
            }),
            'customer' => $this->whenLoaded('customer', function () {
                return ['name_customer' => $this->customer->name_customer];
            }),
        ];
    }

}
