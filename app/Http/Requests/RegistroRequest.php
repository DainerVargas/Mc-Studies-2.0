<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
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
            'name' => 'required',
            'apellido' => 'required',
            'edad' => 'required',
            'direccion' => 'required',
            'fecha_nacimiento' => 'required',
            'telefonoStudent' => 'nullable',
            'emailStudent' => 'nullable',

            'nameAcudiente' => 'required',
            'apellidoAcudiente' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',

            'modality_id' => 'required',
            'group_id' => 'nullable',
            'comprobante' => 'nullable|image'
        ];
    }

    public function messages()
    {

        return  [

            'name.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            'edad.required' => 'La edad es requerida',
            'direccion.required' => 'La dirección es requerida',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es requerida',

            'nameAcudiente.required' => 'El nombre del acudiente es requerido',
            'apellidoAcudiente.required' => 'El apellido del acudiente es requerido',
            'telefono.required' => 'El teléfono es requerido',
            'telefono.number' => 'El teléfono debe contener solo números',
            'telefono.unique' => 'Este número de teléfono ya existe',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no tiene un formato válido',
            'email.unique' => 'Este email ya existe',
            'comprobante.image' => 'Es requerida una imagen para el comprobante',
            'group_id.required' => 'El grupo es requerido',
            'modality_id.required' => 'La modalidad es requerida',
        ];
    }
}
