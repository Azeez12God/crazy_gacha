<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'unique:users|email',
            'password' => 'required|string|min:8',
            'money'=>'integer',
            'profile_picture'=>'string|nullable',
        ];
    }

    public function messages(){
        return [
            'name.required'=>'El nombre de usuario es obligatorio',
            'name.max'=>'El nombre de usuario debe contener menos de 255 caracteres',
            'name.string'=>'El nombre de usuario debe contener solo caracteres',
            'email.email'=>'El correo electronico debe ser valido',
            'email.unique'=>'Ya hay una cuenta con este correo electrónico',
            'password'=>'Error en la contraseña'
        ];
    }
}
