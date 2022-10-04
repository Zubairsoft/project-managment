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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board ,BoardList $list,Card $card)
    {
        $this->authorize('showAllMembers',$board);
        $specific_card= Card::where('list_id',$list->id)->findOrFail($card->id);
        $users=$specific_card->assignedUsers()->get();
  
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
      $this->authorize('assignMember',$board);
      $members= collect([...$request['user_id']])->map(function($value){
        return ['user_id'=>$value];
      });
        $card_board=Board::findOrFail($board->id); 
        $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);
        $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);
       
        $specific_card->assignedUsers()->sync( $members);//sync read the object

        return successResponse($specific_card->assignedUsers,__('response.update.success'),202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberRequest $request,Board $board ,BoardList $list,Card $card)
    {
            $this->authorize('destroyMember',$board);
            $validated_data=$request->validated();
            $card_board=Board::findOrFail($board->id); 
            $list_card=BoardList::where('board_id',$card_board->id)->findOrFail($list->id);
            $specific_card=Card::where('list_id',$list_card->id)->findOrFail($card->id);
            $specific_card->assignedUsers()->detach( $validated_data);
            return successResponse(null,__('response.delete.success'),204);
        
        
    }
}
