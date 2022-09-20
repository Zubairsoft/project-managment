<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RegistrationResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    //
    public function __invoke(RegistrationRequest $request)
    { 
        $validated_data=$request->validated();

        $company=Company::create([
            'name'=>$validated_data['name'],
        ]);
      
        $user=User::create([
                'company_id'=>$company->id,
                'name'=>$validated_data['owner_name'],
                'email'=>$validated_data['email'],
                'password'=>$validated_data['password'],
                'is_active'=>true,
        ]);
        
        
        $user->assignRole('owner');
        $company->owner_id=$user->id;
        $company->save();

        

        if ($company && $user) {
            return successResponse(new RegistrationResource($company),__('registration.response.success'),200);
        }
            return errorResponse([],__('registration.response.error'),404);
    }
}
