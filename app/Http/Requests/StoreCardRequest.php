<?php

namespace App\Http\Requests;

use App\Models\Card;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCardRequest extends FormRequest
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
          
                'title'=>['required','max:254'],
                'description'=>'nullable',
                'priority'=>['required',Rule::in(Card::PRIORITY)],
            
          
          
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>__('validation.required'),
            'title.,max'=>__('validation.max.array'),

            
        ];
    }

}
