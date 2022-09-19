<?php


    /**
     * this function return success response 
     * @param mixed $data=null
     * @param mixed $message='ok'
     * @param mixed $status_code=200
     * 
     * @return json
     */
    function successResponse($data=null,$message='ok',$status_code=200)
    {
        $response= [
            'status'=>true,
            'data'=>$data,
            'message'=>$message,
            'status_code'=>$status_code
        ];
        return response()->json($response,$status_code);


    }


        /**
     * this function return error response 
     * @param mixed $data=null
     * @param mixed $message='ok'
     * @param mixed $status_code=200
     * 
     * @return json
     */
    function errorResponse($data=null,$message='error',$status_code=404)
    {
        $response= [
            'status'=>false,
            'data'=>$data,
            'message'=>$message,
            'status_code'=>$status_code
        ];
        return response()->json($response,$status_code);


    }
