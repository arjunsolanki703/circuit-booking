<?php namespace Cb\Company;

use Backend;
use Backend\Facades\BackendAuth;
use System\Classes\PluginBase;

/**
 * Employees Plugin Information File
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
            'name' => 'cb.company::lang.plugin.name',
            'description' => 'cb.company::lang.plugin.description',
            'author' => 'Hambern',
            'icon' => 'icon-building',
        ];
    }

    public function registerNavigation()
    {
        return [
            'company' => [
                'label' => 'cb.company::lang.plugin.name',
                'url' => Backend::url('cb/company/' . $this->startPage()),
                'icon' => 'icon-building',
                'permissions' => ['cb.company.*'],
                'order' => 500,
                'sideMenu' => [
                    'employees' => [
                        'label' => 'cb.company::lang.employees.menu_label',
                        'icon' => 'icon-user',
                        'url' => Backend::url('cb/company/employees'),
                        'permissions' => ['cb.company.access_employees'],
                    ],
                    'roles' => [
                        'label' => 'cb.company::lang.roles.menu_label',
                        'icon' => 'icon-briefcase',
                        'url' => Backend::url('cb/company/roles'),
                        'permissions' => ['cb.company.access_employees'],
                    ],
                    'projects' => [
                        'label' => 'cb.company::lang.projects.menu_label',
                        'icon' => 'icon-wrench',
                        'url' => Backend::url('cb/company/projects'),
                        'permissions' => ['cb.company.access_projects'],
                    ],
                    'services' => [
                        'label' => 'cb.company::lang.services.menu_label',
                        'icon' => 'icon-certificate',
                        'url' => Backend::url('cb/company/services'),
                        'permissions' => ['cb.company.access_services'],
                    ],
                    'galleries' => [
                        'label' => 'cb.company::lang.galleries.menu_label',
                        'icon' => 'icon-photo',
                        'url' => Backend::url('cb/company/galleries'),
                        'permissions' => ['cb.company.access_galleries'],
                    ],
                    'testimonials' => [
                        'label' => 'cb.company::lang.testimonials.menu_label',
                        'icon' => 'icon-comment',
                        'url' => Backend::url('cb/company/testimonials'),
                        'permissions' => ['cb.company.access_testimonials'],
                    ],
                    'links' => [
                        'label' => 'cb.company::lang.links.menu_label',
                        'icon' => 'icon-link',
                        'url' => Backend::url('cb/company/links'),
                        'permissions' => ['cb.company.access_links'],
                    ],
                    'tags' => [
                        'label' => 'cb.company::lang.tags.menu_label',
                        'icon' => 'icon-tag',
                        'url' => Backend::url('cb/company/tags'),
                        'permissions' => ['cb.company.access_tags'],
                    ],
                ],
            ],
        ];
    }

    public function startPage($page = 'projects')
    {
        $user = BackendAuth::getUser();
        $permissions = array_reverse(array_keys($this->registerPermissions()));
        if (!isset($user->permissions['superuser']) && $user->hasAccess('cb.company.*')) {
            foreach ($permissions as $access) {
                if ($user->hasAccess($access)) {
                    $page = explode('_', $access)[1];
                }
            }
        }
        return $page;
    }

    public function registerPermissions()
    {
        return [
            'cb.company.access_employees' => [
                'label' => 'cb.company::lang.employee.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
            'cb.company.access_projects' => [
                'label' => 'cb.company::lang.project.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
            'cb.company.access_services' => [
                'label' => 'cb.company::lang.service.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
            'cb.company.access_galleries' => [
                'label' => 'cb.company::lang.gallery.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
            'cb.company.access_links' => [
                'label' => 'cb.company::lang.link.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
            'cb.company.access_testimonials' => [
                'label' => 'cb.company::lang.testimonial.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
            'cb.company.access_tags' => [
                'label' => 'cb.company::lang.tag.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
            'cb.company.access_company' => [
                'label' => 'cb.company::lang.company.list_title',
                'tab' => 'cb.company::lang.plugin.name',
            ],
        ];
    }

    public function registerComponents()
    {
        return [
            'Cb\Company\Components\Employees' => 'Employees',
            'Cb\Company\Components\Roles' => 'Roles',
            'Cb\Company\Components\Projects' => 'Projects',
            'Cb\Company\Components\Services' => 'Services',
            'Cb\Company\Components\Galleries' => 'Galleries',
            'Cb\Company\Components\Company' => 'Company',
            'Cb\Company\Components\Testimonials' => 'Testimonials',
            'Cb\Company\Components\Links' => 'Links',
            'Cb\Company\Components\Tags' => 'Tags',
        ];
    }

    public function registerSettings()
    {
        return [
            'company' => [
                'label' => 'cb.company::lang.plugin.name',
                'description' => 'cb.company::lang.settings.description',
                'category' => 'system::lang.system.categories.system',
                'icon' => 'icon-building-o',
                'class' => 'Cb\Company\Models\Company',
                'order' => 500,
                'keywords' => 'cb.company::lang.settings.label',
                'permissions' => ['cb.company.access_company'],
            ],
        ];
    }

    public function register()
    {
        set_exception_handler([$this, 'handleException']);
    }

    public function handleException($e)
    {
        if (!$e instanceof Exception) {
            $e = new \Symfony\Component\Debug\Exception\FatalThrowableError($e);
        }
        $handler = $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler');
        $handler->report($e);
        if ($this->app->runningInConsole()) {
            $handler->renderForConsole(new ConsoleOutput, $e);
        } else {
            $handler->render($this->app['request'], $e)->send();
        }
    }
}
