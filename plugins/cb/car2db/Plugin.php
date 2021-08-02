<?php namespace Cb\Car2db;

use Backend;
use System\Classes\PluginBase;

/**
 * car2db Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'car2db',
            'description' => 'No description provided yet...',
            'author'      => 'cb',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Cb\car2db\Components\ProfilMyVehicle' => 'profilmyvehicle'
        ];
    }
}
