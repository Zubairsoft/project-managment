<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Http\Resources\ProfileResource;
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
        if ($employees->count()==0) {
           return errorResponse(null,__('response.error'),404);
        }
        
        return successResponse($employees,__('response.success'),200);

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
        if ($employee) {
          return successResponse(new ProfileResource($employee),__('registration.response.success'),201);
        }
        return errorResponse(null,__('registration.response.error'),404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {

        $employee=User::findOrFail($id);

        // if ($employee===null)
        // {
        //     return errorResponse(null,__('response.error'),404);
        // }
            return successResponse($employee,__('response.success'),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(StoreEmployee $request, $id)
    { 
       
        $validated_data=$request->validated();
        $employee=User::findOrFail($id);
        // if ( $employee === null) {
        //     # code...
        //     return errorResponse(null,__('response.error'),404);
        // }
         $employee->update($validated_data);
      
          return successResponse($employee ,__('response.success'),201);
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $employee=User::findOrFail($id);
       $employee->delete();
       return successResponse(null,__('response.delete.success'),204);
       

    }
}
