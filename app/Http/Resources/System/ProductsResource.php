<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\System\CategoriesResource;

class ProductsResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name_of_product' => $this->name_of_product,
            'code_of_product' => $this->code_of_product,
            'alert_of_out' => $this->alert_of_out,
            'quantity_of_box' => $this->quantity_of_box,
            'quantity_of_store' => $this->quantity_of_store,
            'fix_number' => $this->fix_number,
            'price_of_buy' => $this->price_of_buy,
            'price_of_sell_tak' => $this->price_of_sell_tak,
            'price_of_sell_ko' => $this->price_of_sell_ko,
            'ShowSelect' => $this->ShowSelect,
            'type_delete' => $this->type_delete,
            'category' => new CategoriesResource($this->whenLoaded('category')),
        ];
    }
}
