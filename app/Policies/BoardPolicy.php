<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

 
    
     /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function index(User $user, Board $board)
    {
        return $user->id===$board->user_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, Board $board)
    {
        return $user->id===$board->user_id;
    }

    public function store(User $user, Board $board)
    {
        return $user->id===$board->user_id;
    }
    

 
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Board $board)
    {
        return $user->id===$board->user_id;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, Board $board)
    {
        return $user->id===$board->user_id;
    }

    /**
     * determine which user can see all cards
     * @param User $user
     * @param Board $board
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function showAll(User $user,Board $board)
    {
    return $user->company_id===$board->creator->company_id;
    }

    /**
     * determine which user can add new card
     * @param User $user
     * @param Board $board
     * 
     * @return [type]
     */
    public function addNewCard(User $user,Board $board)
    {
    return $user->id===$board->user_id;
    }
    /**
     * determine which user can add new card
     * @param User $user
     * @param Board $board
     * 
     * @return [type]
     */
    public function addNewTag(User $user,Board $board)
    {
    return $user->id===$board->user_id;
    }

    /**
     * determine which user can show  card
     * @param User $user
     * @param Board $board
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function showSingleCard(User $user,Board $board)
    {
    return $user->company_id===$board->creator->company_id;
    }

    /**
     * determine which user can update card
     * @param User $user
     * @param Board $board
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateCard(User $user,Board $board)
    {
        return $user->id===$board->user_id;

    }
    
    /**
     * determine which user can destroy card
     * @param User $user
     * @param Board $board
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroyCard(User $user,Board $board)
    {
        return $user->id===$board->user_id;

    }


    
    public function assignMember(User $user,Board $board)
    {
    return $user->id===$board->user_id;
    }

    public function showAllMembers(User $user,Board $board)
    {
    return $user->company_id===$board->creator->company_id;
    }
    public function destroyMember(User $user,Board $board)
    {
        return $user->id===$board->user_id;

    }
    public function create(User $user){
        return true;
    }

    public function view(User $user,Board $board)
    {
return $user->id===$board->user_id;
    }

    public function showTotalCard(){
    return false;
    }

    public function delete(User $user,Board $board)
    {
        return $user->id===$board->user_id;
    }

  
  

}
