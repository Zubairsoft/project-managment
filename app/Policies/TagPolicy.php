<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
 

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, Tag $tag)
    {
       return $user->company_id===$tag->creator->company_id;
    }

    public function view(User $user, Tag $tag)
    {
       return $user->company_id===$tag->creator->company_id;
    }

    

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
   

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Tag $tag)
    {
        return $user->id===$tag->creator_id;
 
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, Tag $tag)
    {
        return $user->id===$tag->creator_id;
    }

    public function create(User $user)
    {
        return $user->hasRole('owner');
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->id===$tag->creator_id;

    }

    

}
