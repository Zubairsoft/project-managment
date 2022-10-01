<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
        return [
            'company_name'=>['required','max:100'],
            'owner_name'=>['required','min:4','max:100'],
            'email'=>['required','email','unique:users,email'],
            'password'=>['required','min:4','confirmed']
            
        ];
    }


    public function messages()
    {
        return [
            'company_name.required'   =>__('registration.company.name.required'),
            'company_name.max'        =>__('registration.company.name.max'),
            'owner_name.min'          =>__('registration.company.owner.min'),
            'owner_name.max'          =>__('registration.company.owner.max'),
            'owner_name.required'     =>__('registration.company.owner.required'),
            'email.unique'            =>__('registration.email.unique'),
            'email.email'            =>__('registration.email.e'),
            'email.required'          =>__('registration.email.required'),
            'password.min'            =>__('registration.password.min'),
            'password.confirmed'      =>__('registration.password.confirmed'),
            'password.required'       =>__('registration.password.required'),



        ];
    }
}
