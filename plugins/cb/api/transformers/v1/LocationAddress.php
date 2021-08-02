<?php

namespace Cb\Api\Transformers\V1;

use Illuminate\Http\Resources\Json\Resource;

class LocationAddress extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'street' => $this->street,
            'additional' => $this->additional,
            'zip' => $this->zip,
            'city' => $this->city,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'email' => $this->email,
            'web' => $this->web,
            'gps_lat' => $this->gps_lat,
            'gps_lon' => $this->gps_lon,
        ];
    }
}
