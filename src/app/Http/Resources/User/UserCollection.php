<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'code'      => Response::HTTP_OK,
            'message'   => __('Request accepted'),
            'data'      => $this->collection
        ];
    }
}
