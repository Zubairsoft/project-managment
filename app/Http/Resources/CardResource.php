<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
    'title'=>$this->title,
    'description'=>$this->description,
    'priority'=>$this->priority,
    'createdAT'=>$this->created_at,
    'updatedAt'=>$this->update_at,
    // 'members'=>MemberResource::collection($this->users),
    

            ];
    }
}
