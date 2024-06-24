<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class OnlyDebtsRequest extends FormRequest
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
                'notice_of_debt' => 'nullable|max:50',
                'created_at' => 'required|date',
            ],
            'PUT' , 'PATCH' => [
                'discount' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'amount_of_debt' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'name_of_recipient' => 'nullable|max:50',
                'notice_of_debt' => 'nullable|max:50',
                'created_at'  => 'required|date',
                'type_delete' => 'max:1|min:0',
            ],
            default => [],
        };
    }
}
