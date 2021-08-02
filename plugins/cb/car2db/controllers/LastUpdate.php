<?php namespace Cb\Car2db\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Last Update Back-end Controller
 */
class LastUpdate extends Controller
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

        BackendMenu::setContext('Cb.Car2db', 'car2db', 'lastupdate');
    }
}
