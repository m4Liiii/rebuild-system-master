<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class SellersRequest extends FormRequest
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
                'name_seller' => 'required|max:35',
                'debt_seller' => 'nullable|numeric|min:-999999999999|max:999999999999',
                'address' => 'nullable|max:35',
                'phone_number' => 'nullable|max:35',
                'social_number' => 'nullable|max:35',
                'notice' => 'nullable|max:40',
                'type_delete' => 'required|max:1|min:0',
                'type_curr' => 'required|max:4|min:0',
            ],
            'PUT' , 'PATCH' => [
                'name_seller' => 'required|max:35',
                'address' => 'nullable|max:35',
                'phone_number' => 'nullable|max:35',
                'notice' => 'nullable|max:40',
                'social_number' => 'nullable|max:35',
                'type_delete' => 'max:1|min:0',
            ],
            default => [],
        };
    }
}
