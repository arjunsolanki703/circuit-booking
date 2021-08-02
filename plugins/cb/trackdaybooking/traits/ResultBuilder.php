<?php
namespace Cb\Trackdaybooking\Traits;

use Config;
use Model;
use Request;

use Cb\Pgmware\Models\Location as LocationModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;
use Cb\Trackdaybooking\Models\Trackday as TrackdayModel;

use Cms\Classes\Theme;

/**
 * Trackday Model
 */
trait ResultBuilder
{
    protected function getUrl($r) {
        return $this->pageUrl('circuits/circuits-item', ["country" => $r->country_slug, "continent" => $r->continent_code, "slug" => $r->slug]);
    }

    protected function prepareResult($list, $onlyGeo = false)
    {
        if (!$onlyGeo) {
            $ids = array_keys(($list->keyBy('id')->toArray()));
            $vehicles = (new VehicleTypeModel())->getByLocation($ids);
        }

        foreach ($list as &$r) {
            if (!$onlyGeo) {
                $r->vehicles = isset($vehicles[$r->id]) ? $vehicles[$r->id] : [];
                $r->type = implode(', ', array_filter(array_unique(explode(',', $r->type))));
                $r->min_length = number_format($r->min_length, 0, '.', ',');
                $r->max_length = number_format($r->max_length, 0, '.', ',');
                $r->grade = array_filter(array_unique(explode(',', $r->grade)));
                $r->fullAddress = $r->address->street . ', ' . $r->address->zip . ', ' . $r->address->city;
                unset($r->address);
            }
//            $r->link = $this->getUrl($r);
//            if ($this->property('isCircuitSharing') && !$onlyGeo) {
                $r->fullAddress = $r->name . ', ' . $r->fullAddress;
                $r->name = $r->shar_title;
//            }
            $tm = TrackdayModel::find($r->trackday_id);
            $r->image = $tm->image->getPath();

//            {% set fl = 'assets/images/flags/' ~ item.country_name|lower|replace({' ': '-', ',': ''}) ~ '.png' %}


            $theme =  Theme::getActiveTheme();
//            $path =  Config::get('cms.themesPath', '/themes').'/'.$theme->getDirName() . '/assets/images/flags/' . strtolower($r->country_slug) . '.png';
//
//            $r->ppath = Config::get('cms.storage.media.path');
            $r->flag_url = asset('/themes/' . $theme->getDirName() . '/assets/images/flags/' . $r->country_slug . '.png');
            $lm = LocationModel::find($r->id);
            $isse = isset($lm->location_scheme);

            if(!empty($lm) && isset($lm->location_scheme)) {
                $r->location_scheme_path = $lm->location_scheme->getPath();
            }
        }
        return $list->toArray();
    }
}
