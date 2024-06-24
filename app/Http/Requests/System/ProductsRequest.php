<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match ($this->method()){

            'POST' => [
                'name_of_product' => 'required|max:40',
                'code_of_product' => 'nullable|max:40',
                'quantity_of_box' => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity_of_store' => 'required|numeric|min:-2147483648|max:2147483647',
                'price_of_buy' => 'required|min:-999999999999|max:999999999999|numeric',
                'price_of_sell_tak' => 'required|min:-999999999999|max:999999999999|numeric',
                'price_of_sell_ko' => 'required|min:-999999999999|max:999999999999|numeric',
                'alert_of_out' => 'nullable|min:-999999999999|max:999999999999|numeric',
                'category_id' => 'required',
                'ShowSelect' => 'required',
                'type_delete' => 'required|max:1|min:0',
            ],
            'PUT' , 'PATCH' => [
                'name_of_product' => 'required|max:40',
                'code_of_product' => 'required|max:40',
                'quantity_of_box' => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity_of_store' => 'required|numeric|min:-2147483648|max:2147483647',
                'price_of_buy' => 'required|min:-999999999999|max:999999999999|numeric',
                'price_of_sell_tak' => 'required|min:-999999999999|max:999999999999|numeric',
                'price_of_sell_ko' => 'required|min:-999999999999|max:999999999999|numeric',
                'alert_of_out' => 'required|min:-999999999999|max:999999999999|numeric',
                'category_id' => 'required',
                'ShowSelect' => 'required',
                'type_delete' => 'max:1|min:0',
            ],

            default => [],
        };
    }
}
