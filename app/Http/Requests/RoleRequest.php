<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|string|max:12|unique:roles,name',
        ],
        'PUT' , 'PATCH' => [
            'name' => ['string','required' , 'max:12',Rule::unique(Role::class, 'name')->ignore($this->route('role')->id)],
        ],
        default => [],
    };
    }
}
