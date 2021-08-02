<?php namespace Cb\UserPlus\Controllers;

use Backend\Classes\Controller;
use Cb\Trackdaybooking\Traits\ResultBuilder;
use RainLab\Location\Models\Country;

class CountryController extends Controller
{
    use ResultBuilder;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return Country::all();
    }
}
