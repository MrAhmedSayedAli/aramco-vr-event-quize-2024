<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    //======================================================>
    public function attributes(): array
    {
        return [
            'user_id' => ' Code',
        ];
    }
    //======================================================>
    public function rules(): array
    {
        return [
            'user_id' => 'required',
        ];
    }
}
