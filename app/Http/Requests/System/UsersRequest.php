<?php

namespace App\Http\Requests\System;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'name' => 'required|string|max:12|unique:users,name',
            'password' => ['required', 'confirmed', Password::defaults()],
        ],
        'PUT' , 'PATCH' => [
            'name' => ['string','required' , 'max:12',Rule::unique(User::class, 'name')->ignore($this->route('user')->id)],
        ],
        default => [],
    };
    }
}
