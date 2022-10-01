<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\CardResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\ProfileResource;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class MemberController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(MemberRequest $request,Board $board ,BoardList $list,Card $card)
    // {
    //     $validated_data=$request->validated();
    //     $card_board=Board::findOrFail($board->id); 
    //     $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);
    //     $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);
    //     $assign_members=$specific_card->users()->syncWithoutDetaching( $validated_data);
    //     return successResponse($specific_card->users,__('response.store.success'),201);

    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board ,BoardList $list,Card $card)
    {
        $specific_card= Card::where('list_id',$list->id)->findOrFail($card->id);
        $users=$specific_card->users()->get();
  
        return successResponse(  MemberResource::collection($users),__('response.success'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign(MemberRequest $request,Board $board ,BoardList $list,Card $card)
    {
      $members= collect([...$request['user_id']])->map(function($r){
        return ['user_id'=>$r];
      });
        $validated_data=$request->validated();
        $card_board=Board::findOrFail($board->id); 
        $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);
        $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);//[1,2]
       
        $update_members=$specific_card->users()->sync( $members);//sync read the object

        return successResponse($specific_card->users,__('response.update.success'),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberRequest $request,Board $board ,BoardList $list,Card $card)
    {
        
            $validated_data=$request->validated();
            $card_board=Board::findOrFail($board->id); 
            $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);
            $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);
            $delete_members=$specific_card->users()->detach( $validated_data);
            return successResponse(null,__('response.delete.success'),204);
        
        
    }
}
