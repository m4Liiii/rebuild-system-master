<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceBuysRequest extends FormRequest
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
                'category_id' => 'nullable',
                'name'  => 'required|max:40',
                'code'  => 'required|max:40',
                'box'   => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity_box' => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity' => 'required|numeric|min:-2147483648|max:2147483647',
                'p_buy' => 'numeric|required|min:-999999999999|max:999999999999',
                'p_buy_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'expense' => 'numeric|required|min:-999999999999|max:999999999999',
                'expense_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'p_all_buy' => 'numeric|required|min:-999999999999|max:999999999999',
                'p_all_buy_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'price_all' => 'numeric|required|min:-999999999999|max:999999999999',
                'price_all_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'sell_ko' => 'numeric|required|min:-999999999999|max:999999999999',
                'sell_tak' => 'numeric|required|min:-999999999999|max:999999999999',
            ],
            'PUT' , 'PATCH' => [
                'box'   => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity_box' => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity' => 'required|numeric|min:-2147483648|max:2147483647',
                'p_buy' => 'numeric|required|min:-999999999999|max:999999999999',
                'p_buy_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'expense' => 'numeric|required|min:-999999999999|max:999999999999',
                'expense_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'p_all_buy' => 'numeric|required|min:-999999999999|max:999999999999',
                'p_all_buy_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'price_all' => 'numeric|required|min:-999999999999|max:999999999999',
                'price_all_curr' => 'numeric|required|min:-999999999999|max:999999999999',
                'sell_ko' => 'numeric|required|min:-999999999999|max:999999999999',
                'sell_tak' => 'numeric|required|min:-999999999999|max:999999999999',
            ],
            default => [],
        };
    }
}
