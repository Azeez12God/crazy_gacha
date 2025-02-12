<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrizesRequest extends FormRequest
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
            'name' => 'required|string',
            'rarity' => 'required|in:Común,Rara,Especial,Épica,Legendaria',
            'reward' => 'required|integer',
            'image' => 'required|string',
            'audio' => 'required|string',
        ];
    }

    public function messages(): array{
        return [
          'name.required' => 'El campo nombre es obligatorio',
          'name.string' => 'El campo nombre debe ser un texto',
          'rarity.required' => 'El campo rareza es obligatorio',
          'rarity.in' => 'El campo rareza debe ser entre Común, Rara, Especial, Épica o Legendaria',
          'reward.required' => 'La recompensa  es obligatoria',
          'reward.integer' => 'La recompensa  debe ser un entero',
          'image.required' => 'La imagen es obligatoria',
          'image.string' => 'La imagen debe ser una url en texto',
          'audio.required' => 'El audio es obligatorio',
          'audio.string' => 'La audio debe ser una url en texto',
        ];
    }
}
