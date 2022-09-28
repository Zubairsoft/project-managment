<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\Card;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board , BoardList $list ,Card $card)
    {
        $comments=Comment::where('card_id',$card->id)->get();
        return successResponse($comments,__('response.success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request,Board $board , BoardList $list ,Card $card)
    {
        $validated_data=$request->validated();
        $validated_data['user_id']=auth()->user()->id;
        $comment=$card->comments()->create($validated_data);
        return successResponse($comment,__('response.store.success'),201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board , BoardList $list ,Card $card, Comment $comment)
    {
        $specific_board=Board::findOrFail($board->id);
        $specific_list=BoardList::where('board_id',$specific_board->id)->findOrFail($list->id);
        $specific_card=Card::where('list_id', $specific_list->id)->findOrFail($card->id);
        $specific_comment=Comment::where('card_id', $specific_card->id)->findOrFail($comment->id);

        return successResponse($specific_comment,__('response.success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request,Board $board , BoardList $list ,Card $card, Comment $comment)
    {
        $this->authorize('update');
        $validated_data=$request->validated();
        $update_comment=$comment->update($validated_data);
        return successResponse($comment,__('response.update.success'),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board , BoardList $list ,Card $card, Comment $comment)
    {
        // $this->authorize('destroy');
        $specific_board=Board::findOrFail($board->id);
        $specific_list=BoardList::where('board_id',$specific_board->id)->findOrFail($list->id);
        $specific_card=Card::where('list_id', $specific_list->id)->findOrFail($card->id);
        $specific_comment=Comment::where('card_id', $specific_card->id)->findOrFail($comment->id);
        $delete_comment=$specific_comment->delete();
        return successResponse(null,__('response.delete.success'),204);
    }
}
