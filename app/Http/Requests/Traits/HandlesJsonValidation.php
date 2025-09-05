<?php

namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HandlesJsonValidation
{
    protected function prepareForValidation(): void
    {
        $json = $this->json()->all();
        if (! empty($json)) {
            $this->merge($json);
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'error' => $validator->errors()->first(),
                'result' => null,
            ], 422)
        );
    }
}
