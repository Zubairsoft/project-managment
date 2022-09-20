<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    /**
     * Handle the Company "deleting" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function deleting(Company $company)
    {
        //
        $company->owner()->delete();
    }

   
}
