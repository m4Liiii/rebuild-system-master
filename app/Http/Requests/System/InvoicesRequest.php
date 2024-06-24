<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
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
                'name'  => 'required|max:40',
                'code'  => 'required|max:40',
                'box'   => 'nullable|numeric|min:-2147483648|max:2147483647',
                'quantity_box' => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity' => 'required|numeric|min:-2147483648|max:2147483647',
                'price' => 'numeric|required|min:-999999999999|max:999999999999',
                'price_all' => 'numeric|required|min:-999999999999|max:999999999999'
            ],
            'PUT' , 'PATCH' => [
                'name'  => 'required|max:40',
                'code'  => 'required|max:40',
                'box'   => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity_box' => 'required|numeric|min:-2147483648|max:2147483647',
                'quantity' => 'required|numeric|min:-2147483648|max:2147483647',
                'price' => 'numeric|required|min:-999999999999|max:999999999999',
                'price_all' => 'numeric|required|min:-999999999999|max:999999999999',
                'get_debt_id' => 'numeric|required|min:-999999999999|max:999999999999'
            ],
            default => [],
        };
    }
}
