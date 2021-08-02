<?php namespace Cb\Leaflet;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Cb\Leaflet\Components\Map' => 'map'
        ];
    }

    public function registerSettings()
    {
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return [
            'cb.leaflet.maps' => [
                'tab' => 'cb.leaflet::lang.permissions.maps.tab',
                'label' => 'cb.leaflet::lang.permissions.maps.label',
            ],
        ];
    }
}
