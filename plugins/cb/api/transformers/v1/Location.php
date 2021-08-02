<?php

namespace Cb\Api\Transformers\V1;

use Illuminate\Http\Resources\Json\Resource;

class Location extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'company_id' => $this->company_id,
            'timezone_id' => $this->timezone_id,
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'name_short' => $this->name_short,
            'name' => $this->name,
            'youtube_video_url' => $this->youtube_video_url,
            'slug' => $this->slug,
            'open_from' => $this->open_from,
            'open_to' => $this->open_to,
            'lunch_from' => $this->lunch_from,
            'lunch_to' => $this->lunch_to,
            'description' => $this->description,
            'equipment' => $this->equipment,
            'specials' => $this->specials,
            'gtc' => $this->gtc,
            'dataprotection_info' => $this->dataprotection_info,
            'module_file' => $this->module_file,
            'facility_overview' => $this->facility_overview,
            'facility_file' => $this->facility_file,
            'logo' => $this->logo,
            'noise' => $this->noise,
            'restaurant' => $this->restaurant,
            'medical' => $this->medical,
            'fuel' => $this->fuel,
            'featured' => $this->featured,
        ];
    }
}
