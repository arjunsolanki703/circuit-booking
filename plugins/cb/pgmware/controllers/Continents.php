<?php namespace Cb\Pgmware\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Continents extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_locations' 
    ];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Cb.Pgmware', 'main-menu-item', 'side-menu-item');
    }
}
