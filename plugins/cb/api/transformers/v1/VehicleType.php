<?php

namespace Cb\Api\Transformers\V1;

use Illuminate\Http\Resources\Json\Resource;

class VehicleType extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->icon,
            'order' => $this->order,
        ];
    }
}
