<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    //
    public function __invoke(StoreCompanyRequest $request)
    { 
        $validated_data=$request->validated();
        $company=Company::create([
            'company_name'=>$validated_data['company_name'],
            'owner_name'=>$validated_data['owner_name'],
        ]);
        $user=User::create([
                'company_id'=>$company->id,
                'name'=>$validated_data['owner_name'],
                'email'=>$validated_data['email'],
                'password'=>$validated_data['password'],
                'isOwner'=>true
        ]);


        if ($company && $user) {
            return successResponse([new CompanyResource($company),new UserResource($user)],__('registration.response.success'),200);
        }
            return errorResponse([],__('registration.response.error'),404);
    }
}
