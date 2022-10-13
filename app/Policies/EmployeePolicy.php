<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;




    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, User $employee)
    {
        return $user->company_id === $employee->company_id;
    }



    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $employee)
    {
        return $user->company_id === $employee->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, User $employee)
    {
        return $user->company_id === $employee->company_id;
    }



    public function viewUsersCard(User $user)
    {
        return $user->hasRole('admin');
    }

    public function create(User $user){
        return true;
    }

    public function view(User $user,User $model){
      return $user->company_id===$model->company_id;
    }

    public function delete(User $user,User $model){
        return $user->company_id===$model->company_id;
    }
}
