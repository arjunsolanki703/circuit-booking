<?php namespace Cb\Pgmware\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Cb\Pgmware\Models\LocationAddress as LocationAddressModel;

class Locations extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Cb.Pgmware', 'main-menu-item', 'side-menu-item');
    }
    
    /*
     * Init proxy field model if we are creating the model
     */
    public function formExtendModel($model)
    {
        if ($this->action == 'create') {
            $model->address = new LocationAddressModel;
        }
        return $model;
    }
}
