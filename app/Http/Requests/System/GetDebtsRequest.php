<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class GetDebtsRequest extends FormRequest
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
                'amount_of_debt' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'discount' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'name_of_recipient' => 'nullable|max:50',
                'name_of_office' => 'nullable|max:50',
                'notice_of_debt' => 'nullable|max:50',
                'created_at' => 'required|date',
                'type_amount' => 'required|min:0|max:1',
                'curr' => 'required|numeric|min:-2147483648|max:2147483647',
                'amount_dollar' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'amount_dinar' => 'nullable|numeric|min:-2147483648|max:2147483647',
                's_id' => 'nullable',
            ],
            'PUT' , 'PATCH' => [
                'discount' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'amount_of_debt' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'name_of_recipient' => 'nullable|max:50',
                'name_of_office' => 'nullable|max:50',
                'notice_of_debt' => 'nullable|max:50',
                'created_at'  => 'required|date',
                'type_amount' => 'min:0|max:1',
                'type_notice' => 'min:0|max:1',
                'type_price' => 'min:0|max:1',
                'customer_id' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'curr' => 'required|numeric|min:-2147483648|max:2147483647',
                'amount_dollar' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'amount_dinar' => 'nullable|numeric|min:-2147483648|max:2147483647',
                'type_delete' => 'max:1|min:0',
                's_id' => 'nullable',
            ],

            default => [],
        };
    }
}
