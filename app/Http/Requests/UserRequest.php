<?php

namespace App\Http\Requests;

use App\Http\Requests\Fails\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use FailedValidation;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Em resource "$this->id" se torna "$this->user"
        return [
            'name' => 'required|min:3|max:255',
            'email' => "required|email|unique:users,email,{$this->user}",
            'password' => "required_if:{$this->user},=,null|min:8|max:255"
        ];
    }
}
