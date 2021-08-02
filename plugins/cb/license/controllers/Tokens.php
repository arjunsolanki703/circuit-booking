<?php namespace Cb\License\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

use Cb\License\Classes\License;

class Tokens extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Cb.License', 'main-menu-item');
    }
}
