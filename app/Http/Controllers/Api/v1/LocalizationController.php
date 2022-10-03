<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocalizationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    public function __invoke(LocalizationRequest $request)
    {
       $validated_data=$request->validated();
     App::setlocale($validated_data['lang']); //change locale app
     session()->put('local',$validated_data['lang']) ;// make session with key local and value the request from lang//todo my cache will be good
     return successResponse(['currentLanguage'=>App::getLocale()=="en"?__('language.en'):__('language.ar')],__('response.update.success'),201);
    }
}
