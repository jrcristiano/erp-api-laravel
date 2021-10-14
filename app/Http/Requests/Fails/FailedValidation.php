<?php

namespace App\Http\Requests\Fails;

use App\Exceptions\FormRequestException;
use Illuminate\Contracts\Validation\Validator;

trait FailedValidation
{
    protected function failedValidation(Validator $validator)
    {
        $errors = json_encode($validator->errors());
        throw (new FormRequestException($errors));
    }
}
