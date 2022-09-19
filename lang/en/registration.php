<?php

return [

    'response'=>[
        'success'=>'data saving successfully',
        'error'=>'error data dose not saving successfully'
       ],

   'password'=>[

    'confirmed'=>'you must confirm your password failed',
    'required'=>'the password failed is required',
    'min'=>"the password failed must be more character"
   ],

   'email'=>[
    'required'=>'the email failed is required',
    'unique'=>'we have an account with this email',
    'email'=>'the email failed is un correctly formate '

   ],
   'company'=>[
    'name'=>[
        'required'=>'the company name is required',
        'min'=>'the company name must be more character',
        'max'=>'the company name must be less than 100 character'
    ],
    'owner'=>[
        'required'=>'the owner name is required',
        'min'=>'the company owner must be more character',
        'max'=>'the company owner must be less than 100 character'
    ]

   ]

];
