<?php

namespace Cb\Api\Transformers\V1;

use Illuminate\Http\Resources\Json\Resource;

class Variant extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'location_id' => $this->location_id,
            'variant_type_id' => $this->variant_type_id,
            'name' => $this->name,
            'cost_type' => $this->cost_type,
            'cost_center' => $this->cost_center,
            'color' => $this->color,
            'description' => $this->description,
            'sort_order' => $this->sort_order,
            'length' => $this->length,
            'bookable' => $this->bookable,
            'grade_deprecated' => $this->grade_deprecated,
            'fia_grade_valid_before_date' => $this->fia_grade_valid_before_date,
            'grade_id' => $this->grade_id,
        ];
    }
}
