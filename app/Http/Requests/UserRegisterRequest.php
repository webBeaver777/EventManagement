<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HandlesJsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    use HandlesJsonValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => 'required|string|unique:users,login',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birth_date' => 'nullable|date',
        ];
    }
}
