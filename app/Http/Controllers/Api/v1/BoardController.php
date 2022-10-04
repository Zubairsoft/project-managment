<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     // 
    public function index()
    {
        $boards=Board::authBoards()->get();
       
       return successResponse($boards,__('response.success'));

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBoardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoardRequest $request)
    {
        $validate_data=$request->validated();
        $validate_data['user_id']=auth()->user()->id;
        $board=Board::create($validate_data);
        return successResponse($board,__('response.store.success'),201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {   
        $this->authorize('show',$board);
        return successResponse($board,__('response.success'),200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBoardRequest  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        $this->authorize('update',$board);
        $validate_data=$request->validated();
        $board->update($validate_data);
        return successResponse($board,__('response.update.success'),202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $this->authorize('destroy',$board);
        $board->delete();
        return successResponse(null,__('response.delete.success'),204);//to do should be 204
     
    }
}
