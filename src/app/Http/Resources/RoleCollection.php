<?php

namespace App\Http\Resources;

use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
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
            'data'      => $this->collection,
            // 'links' => [
            //     'self' => 'link-value',
            // ],
        ];
    }
}
