<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocalizationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $supportLang=['en','ar'];
        return [
           'lang'=>['required',Rule::in($supportLang)]
        ];
    }

    public function messages()
    {
        return [
            'lang.required'=>__('validation.lang.required'),
            'lang'=>__('validation.lang.support')
        ];
    }
}
