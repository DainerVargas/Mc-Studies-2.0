<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|min:4',
            'usuario' => 'required|min:6',
            'email' => 'required',
            'image' => 'nullable|max:2048'
        ];
    }

    public function messages()
    {

        return [
            'required' => 'Este campo es requerido',
            'min' => 'los caracteres son muy cortos',
            'max' => 'El tamaño es muy grande'
        ];
    }
}
