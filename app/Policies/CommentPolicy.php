<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

   public function create(User $user)
   {
   return true;
   }
  
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id===$comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, Comment $comment)
    {
        return $user->id===$comment->user_id;
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id===$comment->user_id;
    }

    public function view(User $user, Comment $comment)
    {
        return $user->company_id===$comment->user->company_id;
    }

    public function canView()
    {
        return false;
    }
}
