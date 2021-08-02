<?php namespace Cb\Trackdaybooking;

use Backend;
use System\Classes\PluginBase;

/**
 * trackdaybooking Plugin Information File
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
            'name'        => 'trackdaybooking',
            'description' => 'Trackdaybooking Based on Booking',
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
            'Cb\Trackdaybooking\Components\BookingProzess' => 'trackdaybookingprozess',
            'Cb\Trackdaybooking\Components\TrackDaysProfile' => 'TrackDaysProfile'

        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    /*public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'cb.trackdaybooking.some_permission' => [
                'tab' => 'trackdaybooking',
                'label' => 'Some permission'
            ],
        ];
    }*/

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    /*public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'trackdaybooking' => [
                'label'       => 'trackdaybooking',
                'url'         => Backend::url('cb/trackdaybooking/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['cb.trackdaybooking.*'],
                'order'       => 500,
            ],
        ];
    }*/
}
