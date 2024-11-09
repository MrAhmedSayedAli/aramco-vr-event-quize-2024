<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    //======================================================>
    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'phone' => 'Mobile number',
            'email' => 'E-mail address',
        ];
    }
    //======================================================>
    public function messages(): array
    {
        return [
            'email.not_regex' => 'Aramco E-mail not allowed',
        ];
    }
    //======================================================>
    public function rules(): array
    {
        return [
            'name' => 'required|min:12',
            'phone' => 'required|numeric|digits:10|unique:players,phone',
            'email' => 'required|email|not_regex:/@aramco\.com$/i',
        ];
    }
}
