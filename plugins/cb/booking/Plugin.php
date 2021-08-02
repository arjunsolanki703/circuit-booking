<?php namespace Cb\Booking;

use Backend;
use System\Classes\PluginBase;

/**
 * booking Plugin Information File
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
            'name'        => 'CB Booking',
            'description' => 'Base Booking Plattfrom',
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
        return []; // Remove this line to activate

        return [
            'Cb\Booking\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    /*public function registerPermissions()
    {
        return [
            'cb.booking.some_permission' => [
                'tab' => 'booking',
                'label' => 'Some permission'
            ],
        ];
    }*/

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    /*
    public function registerNavigation()
    {
        return [
            'booking' => [
                'label'       => 'booking',
                'url'         => Backend::url('cb/booking/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['cb.booking.*'],
                'order'       => 500,
            ],
        ];
    }*/
}
