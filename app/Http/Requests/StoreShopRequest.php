<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
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
            'price' => 'required|numeric',
            'type' => 'required|string|max:255',
            'quantity' => 'required|numeric',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'El nombre de la mejora es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'type.required' => 'El tipo de mejora es obligatorio.',
            'quantity.required' => 'La cantidad es obligatoria.',
        ];
    }
}
