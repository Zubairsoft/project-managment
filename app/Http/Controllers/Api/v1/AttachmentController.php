<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachmentRequest;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Mail\Attachment;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttachmentRequest $request,Board $board,BoardList $list,Card $card)
    {
        $card_board=Board::findOrFail($board->id); // return  board
        $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);// select * lists where id=$card_id and board_id=$board_id
        $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);// select * cards where id=$card_id and list_id=$list_id;

        $specific_card->addMultipleMediaFromRequest(['file'])->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('cards');
        });

        return successResponse($specific_card->getMedia('cards'),__('response.success'),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board,BoardList $list,Card $card,$attachment)
    {
        $media=DB::table('media')->where('uuid',$attachment)->first();
       return successResponse( $media,__('response.success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttachmentRequest $request,Board $board,BoardList $list,Card $card)
    {
        $card_board=Board::findOrFail($board->id);
        $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);
        $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);
        $specific_card->clearMediaCollection('cards');
        $specific_card->addMultipleMediaFromRequest(['file'])->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('cards');
        });
        return successResponse($specific_card->getMedia('cards'),__('response.update'),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board,BoardList $list,Card $card,$attachment)
    {
       DB::table('media')->where('uuid',$attachment)->delete();
       return successResponse(null,__('response.delete.success'),204);
    }
}
