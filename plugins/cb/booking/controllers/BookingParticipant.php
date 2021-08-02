<?php namespace Cb\Booking\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Booking Participant Back-end Controller
 */
class BookingParticipant extends Controller
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

        BackendMenu::setContext('Cb.Booking', 'main-menu-item', 'side-menu-item3');
    }
}
