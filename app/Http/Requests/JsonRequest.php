<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class JsonRequest extends FormRequest {

    /**
     * The data to be validated should be processed as JSON.
     * @return mixed
     */
    // protected function validationData()
    // {
    //     return $this->json()->all();
    // }


    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $factory = $this->container->make('Illuminate\Validation\Factory');

        if (method_exists($this, 'validator'))
        {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }
        return $factory->make(
            $this->json()->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }
}
