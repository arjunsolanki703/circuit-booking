<?php namespace Cb\Trackdaybooking\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Order Trackday Back-end Controller
 */
class OrderTrackday extends Controller
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

        //BackendMenu::setContext('Cb.Trackdaybooking', 'trackdaybooking', 'ordertrackday');
        BackendMenu::setContext('Cb.Trackdaybooking', 'main-menu-item', 'side-menu-item6');

    }
}
