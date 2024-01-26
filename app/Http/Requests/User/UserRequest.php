<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rules = [
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'number_id' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'nullable', 'confirmed', 'string', 'min:8'],
            'password_confirmation' => ['sometimes', 'nullable', 'string'],
        ];

        if ($this->method() == 'POST'){
            array_push($rules['number_id'], 'unique:users,number_id');
            array_push($rules['email'], 'unique:users,email');
            array_push($rules['password'], 'required');
        }else {
            array_push($rules['number_id'], 'unique:users,number_id,' .$this->user->id);
            array_push($rules['email'], 'unique:users,email,' .$this->user->id);
            array_push($rules['password'], 'nullable');
        }

        if ($this->path() != 'api/register'){
            $rules['role'] = ['required', 'string', 'in:user,admin'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser valido',
            'last_name.required' => 'El apellido es requerido',
            'last_name.string' => 'El apellido debe ser válido',
            'email.required' => 'El email es requerido',
            'email.string' => 'El email debe ser valido',
            'password.required' => 'La contraseña es requerida',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ];
    }
}
