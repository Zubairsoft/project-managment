<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board, BoardList $list, Card $card)
    { 
        $this->authorize('showAll', $board);
        $card = Card::where('list_id', $list->id)->findOrFail($card->id);
        $tags = $card->assignedTags()->get();
        return successResponse($tags, __('response.success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request, Board $board, BoardList $list, Card $card)
    {
        $this->authorize('addNewTag',$board);
        $validated_data = $request->validated();
        $validated_data['creator_id'] = auth()->user()->id;
        $tag_board = Board::findOrFail($board->id);
        $tag_list = BoardList::where('board_id', $tag_board->id)->findOrFail($list->id);
        $tag_card = Card::where('list_id', $tag_list->id)->findOrFail($card->id);
        $tag = $tag_card->assignedTags()->create($validated_data);
        return successResponse($tag, __('response.store.success'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board, BoardList $list, Card $card, Tag $tag)
    {
        $tag_board = Board::findOrFail($board->id);
        $tag_list = BoardList::where('board_id', $tag_board->id)->findOrFail($list->id);
        $tag_card = Card::where('list_id', $tag_list->id)->findOrFail($card->id);
        $specific_tag = Tag::where('card_id', $tag_card->id)->findOrFail($tag->id);
        $this->authorize('show', $tag);
        return successResponse($specific_tag, __('response.success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Board $board, BoardList $list, Card $card, Tag $tag)
    {
        $validated_data = $request->validated();
        $tag_board = Board::findOrFail($board->id);
        $tag_list = BoardList::where('board_id', $tag_board->id)->findOrFail($list->id);
        $tag_card = Card::where('list_id', $tag_list->id)->findOrFail($card->id);
        $specific_tag = Tag::where('card_id', $tag_card->id)->findOrFail($tag->id);
        $this->authorize('update', $specific_tag);
        $specific_tag->update($validated_data);
        return successResponse($specific_tag, __('response.update.success'), 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board, BoardList $list, Card $card, Tag $tag)
    {

        $tag_board = Board::findOrFail($board->id);
        $tag_list = BoardList::where('board_id', $tag_board->id)->findOrFail($list->id);
        $tag_card = Card::where('list_id', $tag_list->id)->findOrFail($card->id);
        $specific_tag = Tag::where('card_id', $tag_card->id)->findOrFail($tag->id);
        $this->authorize('destroy', $specific_tag);
        $specific_tag->delete();
        return successResponse(null, __('response.delete.success'), 204);
    }
}
