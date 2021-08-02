<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use Redirect;
use BackendAuth;
use Cb\Pgmware\Models\Location as LocationModel;

class FeaturedLocation extends Country
{
    public function componentDetails()
    {
        return [
            'name'        => 'cb.pgmware::lang.default.featured',
            'description' => ''
        ];
    }

    public function onRun()
    {
        $this->page['featuredLocation'] = $this->loadLocation();
    }

    public function loadLocation()
    {
        $tmp = LocationModel::featured()->with('country', 'address', 'country.continent')->orderBy('country_id')->get();
        $list = [];
        foreach ($tmp as $r) {
            $list[$r->country->continent_id]['continent'] = $r->country->continent;
            $list[$r->country->continent_id]['list'][] = $r;
        }
        return $list;
    }
}