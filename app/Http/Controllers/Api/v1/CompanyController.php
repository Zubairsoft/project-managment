<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateCompanyRequest $request, Company $company)
    {
        $this->authorize('update',$company);
        return $company;
       $validated_data=$request->validated();
       $company->update($validated_data);
       return successResponse(new CompanyResource($company),__('response.success'),202);
       
    }

  
}
