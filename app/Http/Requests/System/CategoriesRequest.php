<?php

namespace App\Http\Requests\System;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
                'name' => 'required|string|max:35',
                'code' => 'nullable|max:35',
                'type_delete' => 'required|max:1|min:0',
            ],
            'PUT' , 'PATCH' => [
                'name' => 'required|max:35',
                'code' => 'required|max:35',
                'type_delete' => 'max:1|min:0',
            ],

            default => [],
        };
    }
}
