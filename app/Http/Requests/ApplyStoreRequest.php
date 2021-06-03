<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyStoreRequest extends FormRequest
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
            'eula' => 'required',
            'declare' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'eula.required' => 'You forget to accept terms and conditions !',
            'declare.required' => 'Declaration is required !'
        ];
    }
}
