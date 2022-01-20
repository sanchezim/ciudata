<?php

namespace App\Http\Resources;

use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'code'      => Response::HTTP_OK,
            'message'   => __('Request accepted'),
            'id'        => $this->id,
            'name'      => $this->name,
        ];
    }
}
