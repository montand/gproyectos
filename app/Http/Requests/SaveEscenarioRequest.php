<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveEscenarioRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
         'cnombre' => 'required',
         'tema_id' => 'required',
         'ntotcosto' => 'nullable',
         'ntotrh' => 'nullable'
        ];
    }

    public function messages(){
        return [
            'cnombre.required' => 'Falta especificar el nombre',
            'tema_id.required' => 'Falta especificar el tema'
        ];
    }
}
