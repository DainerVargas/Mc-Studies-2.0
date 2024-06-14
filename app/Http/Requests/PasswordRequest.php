<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'antigua' => 'required',
            'nueva' => 'required|min:8|different:antigua|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirm' => 'required|same:nueva',
        ];
    }

    public function messages()
    {

        return [
            'required' => 'Este campo es obligatorio.',
            'nueva.min' => 'Requerido minimo 8 caracteres.',
            'nueva.regex' => 'Requerido al menos una letra minúscula, mayúscula y un número.',
            'confirm.same' => 'Las Contraseñas no coinciden.',
        ];
    }
}
