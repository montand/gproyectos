<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProyectoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: para implementar con roles
        // return $this->user()->isAdmin();
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
            'cclave' => 'required',
            'cnombre' => 'required',
            'cdescripcion' => 'nullable',
            'cjustificacion' => 'nullable',
            // 'ncosto' => 'required|gt:0',
            // 'nduracion' => 'required',
            // 'unidades_rh' => 'required|gt:0',
            'criterios' => 'nullable'
        ];
    }

    public function messages(){
        return [
            'cclave.required' => 'Falta especificar la clave del proyecto',
            'cnombre.required' => 'Falta especificar el nombre del proyecto',
            // 'ncosto.required' => 'Falta especificar el costo del proyecto',
            // 'ncosto.gt' => 'El costo debe ser mayor que cero',
            // 'nduracion.required' => 'Falta especificar la duración del proyecto',
            // 'unidades_rh.required' => 'Falta especificar las unidades HH del proyecto',
            // 'unidades_rh.gt' => 'Las unidades HH debe ser un número mayor que cero'
        ];
    }
}
