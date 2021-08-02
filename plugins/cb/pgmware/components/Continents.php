<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Cb\Pgmware\Models\Continent as ContinentModel;
use Lang;

class Continents extends ComponentBase
{
    public $continents;

    public $noPostsMessage;

    public $continentPage;

    public function componentDetails()
    {
        return [
            'name'        => 'cb.pgmware::lang.default.continents',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'continentPage' => [
                'title'       => 'cb.pgmware::lang.component.continent_page_title',
                'description' => 'cb.pgmware::lang.component.continent_page_description',
                'type'        => 'dropdown',
                'default'     => ''
            ]
        ];
    }

    public function getContinentPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->continentPage = $this->page['continentPage'] = $this->property('continentPage');
        $this->continents = $this->page['continents'] = $this->listContinents();
    }

    protected function listContinents()
    {
        $continents = ContinentModel::isEnabled()->get();

        $continents->each(function($continent) {
            $continent->setUrl($this->continentPage, $this->controller);
        });

        return $continents;
    }
}
