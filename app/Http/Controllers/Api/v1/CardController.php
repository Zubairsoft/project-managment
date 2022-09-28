<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Board;
use App\Models\BoardList;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board,BoardList $list)
    {
        $cards=Card::where('list_id',$list->id)->get();
        return successResponse($cards,__('response.success'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardRequest $request,Board $board ,BoardList $list)
    {
        return $request['card'];
        $validated_data=$request[0]->validated();
        $card=$list->cards()->create($validated_data);
        return successResponse($card,__('response.store'),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board ,BoardList $list,Card $card)
    { 
        $card_board=Board::findOrFail($board->id); // return  board
        $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);// select * lists where id=$card_id and board_id=$board_id
        $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);// select * cards where id=$card_id and list_id=$list_id;

        return successResponse($specific_card,__('response.success'));
    }

 
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCardRequest  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardRequest $request,Board $board,BoardList $list, Card $card)
    {
        $validated_data=$request->validated();
        $update_card=$card->update($validated_data);
        return successResponse($card,__('response.update.success'),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board,BoardList $list,Card $card)
    {
      $delete_card=$card->delete();
      return successResponse(null,__('response.delete.success'),204);
    }
}
