<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

   

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Company $company)
    {
        //
        return $user->id===$company->owner_id;
    }

    public function viewAny(User $user)
    {
        return true;
    }
    public function view(User $user , Company $company)
    {
  return $user->id===$company->owner_id;
    }

   public function viewCompanyCard(User $user){
    return $user->hasRole('admin');
   }
   

}
