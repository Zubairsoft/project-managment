<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CardPolicy
{
    use HandlesAuthorization;

    public function view(User $user ,Card $card){
        return $user->id===$card->list->board->user_id;
    }

    public function create(){
        return true;
    }

    public function update(User $user ,Card $card)
    {
        return $user->id===$card->list->board->user_id;

    }

    public function delete(User $user ,Card $card)
    {
        return $user->id===$card->list->board->user_id;

    }

  

    /**
     * Determine whether the user can add the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addNewComment(User $user, Card $card)
    {
        foreach ($card->assignedUsers->pluck('id') as $value) {
            if ($user->id==$value) {
                return true;
            }
        }
        foreach ($card->assignedUsers as  $value) {
            if ($value->companyMember->owner_id==$user->id) {
                return true;
            }
        }
    }

    public function changeCardList(User $user, Card $card)
    {
        foreach ($card->assignedUsers->pluck('id') as $value) {
            if ($user->id==$value) {
                return true;
            }
        }
        foreach ($card->assignedUsers as  $value) {
            if ($value->companyMember->owner_id==$user->id) {
                return true;
            }
        }

    }

  
}
