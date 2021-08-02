<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use RainLab\Location\Models\Country as CountryModel;
use Redirect;
use BackendAuth;
use Cb\Pgmware\Components\Continent;

class Country extends Continent
{
    public $country;

    public function componentDetails()
    {
        return [
            'name'        => 'cb.pgmware::lang.default.country',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
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
            ]
        ];
    }

    public function onRun()
    {
        $this->continent = $this->page['continent'] = $this->loadContinent();
        $this->country = $this->page['country'] = $this->loadCountry();
    }

    protected function loadCountry()
    {
        $slug = $this->property('countrySlug');

        $country = new CountryModel;
        $country = $country->where('cb_slug', $slug)->isEnabled();

        if ($country->count() == 0 || !$country = $country->first()) {
            return $this->controller->run('404');
        }
        if (!isset($this->continent->id) || $this->continent->id != $country->cb_continent_id) {
            return $this->controller->run('404');
        }

        $this->page->title = $country->name;
        $this->page->meta_title = $country->name;

        return $country;
    }
}
