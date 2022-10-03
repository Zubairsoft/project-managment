<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'userName'=>$this->name,//todo need discussion
            'email'=>$this->email,
            'role'=>$this->getRoleNames()[0],
            'companyInfo'=> new CompanyResource($this->companyMember)//todo need discussion
        ];
    }
}
