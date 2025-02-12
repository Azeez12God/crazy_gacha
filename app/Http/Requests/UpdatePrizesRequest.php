<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrizesRequest extends FormRequest
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
            'name' => 'string',
            'rarity' => 'in:Común,Rara,Especial,Épica,Legendaria',
            'reward' => 'integer',
            'image' => 'string',
            'audio' => 'string',
        ];
    }

    public function messages(): array{
        return [
            'name.string' => 'El campo nombre debe ser un texto',
            'rarity.in' => 'El campo rareza debe ser entre Común, Rara, Especial, Épica o Legendaria',
            'reward.integer' => 'La recompensa  debe ser un entero',
            'image.string' => 'La imagen debe ser una url en texto',
            'audio.string' => 'La audio debe ser una url en texto',
        ];
    }
}
