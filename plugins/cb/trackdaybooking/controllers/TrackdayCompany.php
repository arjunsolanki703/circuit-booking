<?php namespace Cb\Trackdaybooking\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Trackday Company Back-end Controller
 */
class TrackdayCompany extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Cb.Trackdaybooking', 'main-menu-item', 'trackdaycompany');
    }
}
