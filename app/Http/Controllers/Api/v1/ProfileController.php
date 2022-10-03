<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function __invoke(ProfileRequest $request)
    {
        $user=auth()->user();

        $validated_data=$request->validated();
       if ($user->update($validated_data)){//todo why ?
        return successResponse(new ProfileResource($user),__('response.update.success'),201);
       }
       return errorResponse(null,__('response.update.error'),404);//todo why ?
}
}
