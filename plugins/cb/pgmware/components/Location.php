<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use Request;
use Redirect;
use BackendAuth;
use Cb\Pgmware\Components\Country;
use Cb\Pgmware\Models\Location as LocationModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Lastminute as LastminuteModel;

class Location extends Country
{
    public $location;

    public function componentDetails()
    {
        return [
            'name'        => 'cb.pgmware::lang.default.location',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'isCircuitSharing' => [
                'title'       => 'cb.pgmware::lang.default.sharing',
                'description' => '',
                'default'     => '',
                'type'        => 'checkbox',
            ],
            'slug' => [
                'title'       => 'slug',
                'description' => '',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'countrySlug' => [
                'title'       => 'slug',
                'description' => '',
                'default'     => '{{ :country }}',
                'type'        => 'string'
            ],
            'continentSlug' => [
                'title'       => 'continent',
                'description' => '',
                'default'     => '{{ :continent }}',
                'type'        => 'string'
            ],
            'startDateDefault' => [
                'title'       => 'startDate',
                'description' => '',
                'default'     => Request::input('start_day') ? date('Y-m-d', strtotime(Request::input('start_day'))) : '',
                'type'        => 'string'
            ],
            'endDateDefault' => [
                'title'       => 'endDate',
                'description' => '',
                'default'     => Request::input('end_day') ? date('Y-m-d', strtotime(Request::input('end_day'))) : '',
                'type'        => 'string'
            ]
        ];
    }

    public function onRun()
    {
        if ($this->property('isCircuitSharing')) {
            $this->loadLocationSharing();
        } else {
            $this->continent = $this->page['continent'] = $this->loadContinent();
            $this->country = $this->page['country'] = $this->loadCountry();
            $this->location = $this->page['location'] = $this->loadLocation();
        }
        if (!isset($this->location) || !isset($this->location->id)) {
            return $this->controller->run('404');
        }

        $dateStart = $this->location->open_from;
        if (! $this->dateStart || (strtotime($this->dateStart) < strtotime(date('Y-m-d')))) {
            $dateStart = date('Y-m-d');
        }
        $this->page['dateEnd'] = $this->location->open_to ? date('Y-m-d', strtotime($this->location->open_to)) : null;
        $this->page['dateStart'] = $dateStart ? date('Y-m-d', strtotime($dateStart)) : null;
    }

    protected function loadLocation()
    {
        $slug = $this->property('slug');

        $location = new LocationModel;
        $location = $location->where('slug', $slug);

        if ($location->count() == 0 || !$location = $location->first()) {
            return $this->controller->run('404');
        }
        if (!isset($this->country->id) || $location->country_id != $this->country->id) {
            return $this->controller->run('404');
        }
        $location->variants = VariantModel::with('vehicleTypes', 'variantType', 'grade')
            ->bookable()
            ->where('location_id', $location->id)
            ->get();
        $this->page->title = $location->name;
        $this->page->meta_title = $location->name;

        foreach ($location->variants as $v) {
            $v->length = number_format($v->length, 0, '.', ',');
        }

        $this->page['sharingCrossCount'] = (new CircuitSharingModel())->getActiveRecordsCount($location->id);
        $this->page['lastCrossCount'] = (new LastminuteModel())->getActiveRecordsCount($location->id);

        return $location;
    }

    protected function loadLocationSharing()
    {
        $slug = $this->property('slug');
        $location = new LocationModel;
        $location = $location->where('slug', $slug);
        if ($location->count() == 0 || !$location = $location->first()) {
            return $this->controller->run('404');
        }
        $this->page->title = $location->name;
        $this->page->meta_title = $location->name;
        $this->location = $this->page['location'] = $location;
        $this->continent = $this->page['continent'] = $location->country->continent;
        $this->country = $this->page['country'] = $location->country;
        $this->page['circuitSharing'] = (new CircuitSharingModel())->getActiveRecords($this->location->id);

        $types = [];
        foreach ($this->location->variants as $v) {
            $v->length = number_format($v->length, 0, '.', ',');
            foreach ($v->vehicleTypes as $r) {
                $types[$r->id]['name'] = $r->name;
                $types[$r->id]['id'] = $r->id;
            }
        }
        $this->page['vehicleTypes'] = $types;
    }
}
