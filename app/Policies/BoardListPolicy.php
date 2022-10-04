<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\BoardList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardListPolicy
{
    use HandlesAuthorization;

     /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Auth\Access\Response|bool
     */
   
    /**
     * Determine if the current user add list in his board
     * @param User $user
     * @param Board $board
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
   

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BoardList  $boardList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, BoardList $boardList)
    {
        //
    }

  

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BoardList  $boardList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, BoardList $boardList)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BoardList  $boardList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, BoardList $boardList)
    {
        //
    }

}
