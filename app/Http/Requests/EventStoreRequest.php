<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HandlesJsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{
    use HandlesJsonValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
