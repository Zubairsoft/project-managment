<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeCardListRequest;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;

class ChangeCardListController extends Controller
{
    public function __invoke (ChangeCardListRequest $request,Board $board ,BoardList $list ,Card $card)
    {
        // return $card;
    $validated_data=$request->validated();
     $update_card=$card->update( $validated_data);
     return successResponse($card,__('response.update.success'),201);
    }
}
