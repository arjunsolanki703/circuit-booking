<?php

namespace Cb\Leaflet\Components;

use Cb\Leaflet\Models\Maps;
use Request;
use RainLab\Location\Models\Country;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;

class Map extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'cb.leaflet::lang.component.name',
            'description' => 'cb.leaflet::lang.component.map.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'isCircuitSharing' => [
                'title'       => 'cb.pgmware::lang.default.sharing',
                'description' => '',
                'default'     => 0,
                'type'        => 'checkbox',
            ],
            'map' => [
                'title' => 'cb.leaflet::lang.component.map.title',
                'description' => 'cb.leaflet::lang.component.map.description',
                'type' => 'dropdown',
                'required' => true,
            ],
            'showOnlyObject' => [
                'title' => 'cb.leaflet::lang.component.show_only_object.title',
                'description' => 'cb.leaflet::lang.component.show_only_object.description',
                'type' => 'dropdown',
                'depends' => ['map']
            ],
            'fieldId' => [
                'title' => 'cb.leaflet::lang.component.fieldId.title',
                'description' => 'cb.leaflet::lang.component.fieldId.description',
                'default' => 'map',
                'type' => 'string',
                'required' => true,
            ],
            'height' => [
                'title' => 'cb.leaflet::lang.component.height.title',
                'description' => 'cb.leaflet::lang.component.height.description',
                'default' => '400px',
                'type' => 'string',
                'required' => true,
            ],
            'latitude' => [
                'title' => 'cb.leaflet::lang.component.latitude.title',
                'description' => 'cb.leaflet::lang.component.latitude.description',
                'default' => 0,
                'type' => 'string',
                'required' => true,
            ],
            'longitude' => [
                'title' => 'cb.leaflet::lang.component.longitude.title',
                'description' => 'cb.leaflet::lang.component.longitude.description',
                'default' => 0,
                'type' => 'string',
                'required' => true,
            ],
            'zoom' => [
                'title' => 'cb.leaflet::lang.component.zoom.title',
                'description' => 'cb.leaflet::lang.component.zoom.description',
                'default' => 3,
                'type' => 'string',
                'required' => true,
            ],
            //Waiting for taglist support in components
            /*
            'objectDisplayList' => [
                'title'              => 'timfoerster.leaflet::lang.component.object_display_list.title',
                'description'       => 'timfoerster.leaflet::lang.component.zoom.description',
                'type'                => 'taglist',
                'separator'         => 'comma'
            ]
            */
        ];
    }

    public function getMapOptions()
    {
        return Maps::orderBy('name')->lists('name', 'id');
    }

    public function getShowOnlyObjectOptions()
    {

        $mapId = Request::input('map');
        if ($mapId == null) {
            $firstMap = Maps::orderBy('name')->first();
            if ($firstMap != null) {
                $mapId = $firstMap->id;
            }
        }

        $map = $this->mapQuery()->find($mapId);

        $objects = [trans("cb.leaflet::lang.component.show_only_object.all")];

        if ($map) {
            $objects = array_replace_recursive($objects, $map->objects->lists('name', 'id'));
        }

        return $objects;
    }

    /*
     * Waiting for taglist support in components
    public function getObjectDisplayListOptions() {
        $map = $this->findMap();
        return $map->objects->list('name', 'id');
    }
    */

    public function onRun()
    {
        $this->page['map'] = $this->map();
        if ($this->property('isCircuitSharing')) {
            //$this->page['circuitSharing'] = (new CircuitSharingModel())->getActiveRecords();
        } else {
            $this->page['countries'] = $this->loadCountries();
        }

        //$this->addJs('/plugins/cb/leaflet/assets/leaflet/leaflet.js');
        //$this->addCss('/plugins/cb/leaflet/assets/leaflet/leaflet.css');
        $this->addJs('/plugins/cb/leaflet/assets/mapbox/mapbox.js');
        $this->addCss('/plugins/cb/leaflet/assets/mapbox/mapbox.css');
        
        $this->addJs('/plugins/cb/leaflet/assets/leaflet/Control.FullScreen.js');
        $this->addCss('/plugins/cb/leaflet/assets/leaflet/Control.FullScreen.css');
    }

    public function map()
    {

        $map = $this->mapQuery()->find($this->property('map'));
        $map->fieldId = $this->property('fieldId');
        $map->latitude = $this->property('latitude');
        $map->longitude = $this->property('longitude');
        $map->zoom = $this->property('zoom');
        $map->height = $this->property('height');

        $showOnlyObject = $this->property('showOnlyObject');

        if ($showOnlyObject == null || $showOnlyObject == 0) {
            $map->objectsToDisplay = $map->objects;
        } else {
            $map->objectsToDisplay = $map->objects->filter(function ($object) use ($showOnlyObject) {
                return $showOnlyObject == $object->id;
            });
        }
        return $map;
    }

    protected function mapQuery()
    {
        return Maps::with('objects');
    }

    public function loadCountries()
    {
        $t = Country::isEnabled()->get();
        $ar = [];
        foreach ($t as $r) {
            if (isset($r->continent)) {
                $r->cb_geojson = json_decode($r->cb_geojson);
                $r->cb_geojson->properties->url = $this->pageUrl('circuits/country', ['country' => $r->cb_slug, 'continent' => $r->continent->code]); //"{{ 'circuits/country'|page }}";
                $r->cb_geojson = json_encode($r->cb_geojson);
                $ar[] = $r;
            }
        }
        return $ar;
    }

}