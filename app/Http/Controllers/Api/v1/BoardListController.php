<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BoardList;
use App\Http\Requests\StoreBoardListRequest;
use App\Http\Requests\UpdateBoardListRequest;
use App\Http\Resources\BoardListResource;
use App\Models\Board;

class BoardListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Board $board)
    {
        $this->authorize('index',$board);
        $lists=BoardList::where('board_id',$board->id)->get();
        return successResponse(BoardListResource::collection($lists),__('response.success'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBoardListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoardListRequest $request,Board $board)
    {
        $this->authorize('store',$board);
        $validated_data=$request->validated();
        $list=$board->lists()->create($validated_data);
        return successResponse($list,__('response.store.success'),201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BoardList  $boardList
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board,BoardList $list)
    {
        $this->authorize('show',$board);
        return successResponse(new BoardListResource($list),__('response.success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBoardListRequest  $request
     * @param  \App\Models\BoardList  $boardList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoardListRequest $request,Board $board ,BoardList $list)
    {
        $this->authorize('update',$board);
        $validated_data=$request->validated();
        $list->update($validated_data);
        return successResponse($list,__('response.update.success'),202);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BoardList  $boardList
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board,BoardList $list)
    {
        $this->authorize('destroy',$board);
       $list->delete();
       return successResponse(null,__('response.delete.success'),204);
    }
}
