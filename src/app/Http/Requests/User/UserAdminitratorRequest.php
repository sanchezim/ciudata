<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserAdminitratorRequest extends FormRequest
{
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
        return [
            "idProfile"         => 'required|exists|profiles,id',
            "firstName"         => 'required|string|max:255',
            "secondName"        => 'string|max:255',
            "firstLastName"     => 'required|string|max:255',
            "secondLastName"    => 'required|string|max:255',
            "email"             => 'required|email|unique:users,email'
        ];
    }
}
