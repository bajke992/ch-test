<?php

namespace App\Http\Requests\Auth;

class RegistrationPostRequest extends RegistrationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|confirmed'
        ];
    }
}
