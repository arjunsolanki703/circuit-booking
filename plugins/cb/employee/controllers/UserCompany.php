<?php namespace Cb\Employee\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * User Company Back-end Controller
 */
class UserCompany extends Controller
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

        BackendMenu::setContext('RainLab.User', 'user', 'employees');
    }
}
