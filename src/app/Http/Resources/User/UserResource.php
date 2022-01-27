<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'             => $this->id,
            'type'           => $this->id_profile,
            'fullName'       => $this->fullName,
            'firstName'      => $this->first_name,
            'secondName'     => $this->second_name,
            'firstLastName'  => $this->first_last_name,
            'secondLastName' => $this->second_last_name,
            'email'          => $this->email,
            'roles'          => [],
            'permissions'    => []
        ];
    }
}
