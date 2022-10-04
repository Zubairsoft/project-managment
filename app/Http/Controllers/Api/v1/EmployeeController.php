<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

use function PHPUnit\Framework\isEmpty;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages=$request->page??10;
        $employees=User::getEmployees()->paginate($pages);
        return successResponse( UserResource::collection($employees),__('response.success'),200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployee $request)
    {
        $validated_data=$request->validated();
        $validated_data['company_id']=auth()->user()->company_id;
        $employee=User::create( $validated_data);
        $employee->assignRole('employee');
        return successResponse(new ProfileResource($employee),__('registration.response.success'),201);
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $employee)
    {
        $this->authorize('show',$employee);
         return successResponse($employee,__('response.success'),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(UpdateEmployee $request, User $employee)
    { 
       $this->authorize('update',$employee);
        $validated_data=$request->validated();
        $employee->update($validated_data);
         return successResponse($employee ,__('response.success'),202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $employee)
    {
        $this->authorize('destroy',$employee);
       $employee->delete();
       return successResponse(null,__('response.delete.success'),204);
    
    }
}
