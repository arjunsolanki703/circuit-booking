<?php

namespace Cb\Api\Transformers\V1;

use Illuminate\Http\Resources\Json\Resource;

class VariantType extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
        ];
    }
}
