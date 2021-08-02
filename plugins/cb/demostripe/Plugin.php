<?php namespace Cb\Demostripe;

use Backend;
use System\Classes\PluginBase;

/**
 * demostripe Plugin Information File
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
            'name'        => 'demostripe',
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
            'Cb\Demostripe\Components\Booktrack' => 'bookTrack',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'cb.demostripe.some_permission' => [
                'tab' => 'demostripe',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'demostripe' => [
                'label' => 'demostripe',
                'url' => Backend::url('cb/demostripe/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['cb.demostripe.*'],
                'order' => 500,
            ],
        ];
    }
}
