<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
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

        $employees=User::getEmployees()->get();
        $employees_ids=$employees->pluck('id');
        return [
              'user_id'=>'array',
              'user_id.*'=>['required',Rule::in($employees_ids)]
        
              ];
        // if ($this->isMethod('POST')) {

        //     return $this->store();
       
        //    }elseif($this->isMethod('PATCH')){
       
        //        return $this->update(  $employees_ids);
       
        //    }elseif($this->isMethod('delete')){
        //        return $this->delete($employees_ids);
        //    }
       
    }
    public function messages()
    {
   return [
    'user_id.required'=>__('validation.required'),
    'user_id'=>'id is not felid'
   ];

    }

    // public function store()
    // {
    //     return [
    //         'user_id'=>'array',
    //         'user_id.*'=>['required']

    //       ];
    // }

    // public function update ($ids)
    // {
    //     return [
    //         'user_id'=>['required',Rule::in($ids)]
    //       ];
    // }

    // public function delete($ids)
    // {
    //     return [
    //         'user_id'=>['required',Rule::in($ids)]
    //       ];
    // }
}
