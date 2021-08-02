<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use Cb\Pgmware\Models\Continent as ContinentModel;
use Redirect;
use BackendAuth;

class Continent extends ComponentBase
{
    public $continent;

    public function componentDetails()
    {
        return [
            'name'        => 'cb.pgmware::lang.default.continent',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'continentSlug' => [
                'title'       => 'slug',
                'description' => '',
                'default'     => '{{ :continent }}',
                'type'        => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->continent = $this->page['continent'] = $this->loadContinent();
    }

    protected function loadContinent()
    {
        $slug = $this->property('continentSlug');

        $continent = new ContinentModel;
        $continent = $continent->where('code', $slug)->isEnabled();

        if ($continent->count() == 0 || !$continent = $continent->first()) {
            return $this->controller->run('404');
        }

        $this->page->title = $continent->name;
        $this->page->meta_title = $continent->name;
        
        $continent->countriesExtend = $continent->getCountries();

        return $continent;
    }
}
