<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke(ProfileRequest $request)
    {
        $user=auth()->user();
        $validated_data=$request->validated();
        $user->update($validated_data);
        return successResponse(new ProfileResource($user),__('response.update.success'),202); 
}
}
