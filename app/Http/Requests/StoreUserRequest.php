<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'unique:users|email',
            'password' => 'required|string|min:8',
            'money' => 'integer',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre de usuario es obligatorio',
            'name.max' => 'El nombre de usuario debe contener menos de 255 caracteres',
            'name.string' => 'El nombre de usuario debe contener solo caracteres',
            'email.email' => 'El correo electrónico debe ser válido',
            'email.unique' => 'Ya hay una cuenta con este correo electrónico',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'money.integer' => 'El campo dinero debe ser un número entero',
        ];
    }

    /**
     * Personaliza la respuesta en caso de validación fallida.
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors(),
            'data' => null
        ], 422));
    }
}
