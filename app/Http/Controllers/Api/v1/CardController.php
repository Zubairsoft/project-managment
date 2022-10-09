<?php

namespace App\Http\Controllers\Api\v1;

use App\Filter\FilterCardByAssigned;
use App\Filter\FilterCardByDescription;
use App\Filter\FilterCardByList;
use App\Filter\FilterCardByPriority;
use App\Filter\FilterCardByTag;
use App\Filter\FilterCardByTitle;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Resources\CardResource;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CardController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  //todo append attachment at card if exits
  public function index(Board $board, BoardList $list)
  {
    $this->authorize('showAll', $board);
    $cards = Card::allCardWithSortWithPriority($list->id)->get();
    return successResponse(CardResource::collection($cards), __('response.success'));
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreCardRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreCardRequest $request, Board $board, BoardList $list)
  {
    $this->authorize('addNewCard', $board);
    $validated_data = $request->validated();
    $card = $list->cards()->create($validated_data);
    return successResponse(new CardResource($card), __('response.store'), 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function show(Board $board, BoardList $list, Card $card)
  {
    $this->authorize("showSingleCard", $board);
    $card_board = Board::findOrFail($board->id); // return  board
    $list_card = BoardList::where('board_id', $card_board->id)->findOrFail($list->id); // select * lists where id=$card_id and board_id=$board_id
    $specific_card = Card::where('list_id', $list_card->id)->findOrFail($card->id); // select * cards where id=$card_id and list_id=$list_id;

    return successResponse(new CardResource($specific_card), __('response.success'));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateCardRequest  $request
   * @param  \App\Models\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateCardRequest $request, Board $board, BoardList $list, Card $card)
  {
    $this->authorize('updateCard', $board);
    $validated_data = $request->validated();
    $card->update($validated_data);
    return successResponse(new CardResource($card), __('response.update.success'), 202);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function destroy(Board $board, BoardList $list, Card $card)
  {
    $this->authorize('destroyCard', $board);
    $card->delete();
    return successResponse(null, __('response.delete.success'), 204);
  }



  /**
   * this function make filter for card
   * @param Board $board
   * 
   * @return [collection]
   */
  public function filter(Board $board)
  {
    $model=Card::whereHas('list',function(Builder $query)use($board){
      $query->where('board_id',$board->id);
    });
   
    
    $filter = QueryBuilder::for($model)
      ->allowedFilters([
         AllowedFilter::custom('title',new FilterCardByTitle),
         AllowedFilter::custom('des',new FilterCardByDescription),
         AllowedFilter::custom('list',new FilterCardByList),
         AllowedFilter::custom('card_priority',new FilterCardByPriority),
         AllowedFilter::custom('assigned',new FilterCardByAssigned),
         AllowedFilter::custom('tag',new FilterCardByTag)
      ])->defaultSort('priority', '-created_at')
      ->allowedSorts('priority', 'created_at')
      ->paginate()
      ->appends(request()->query());
    return successResponse($filter, __('response.success'));
  }
}
