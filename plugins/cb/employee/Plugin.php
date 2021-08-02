<?php namespace Cb\Employee;

use Backend;
use System\Classes\PluginBase;
use Lang;
use Event;

/**
 * employee Plugin Information File
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
            'name'        => 'employee',
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
        Event::listen('backend.menu.extendItems', function($manager) {
            $manager->addSideMenuItems('RainLab.User', 'user', [
                'employees' => [
                    'label' => 'Employees',
                    'icon' => 'icon-user-plus',
                    'url' => '/backend/cb/employee/UserCompany'
                ]
            ]);
        });
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
            'Cb\Employee\Components\MyComponent' => 'myComponent',
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
            'cb.employee.some_permission' => [
                'tab' => 'employee',
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
            'employee' => [
                'label'       => 'employee',
                'url'         => Backend::url('cb/employee/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['cb.employee.*'],
                'order'       => 500,
            ],
        ];
    }*/
}
