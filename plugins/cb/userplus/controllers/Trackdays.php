<?php namespace Cb\UserPlus\Controllers;

use Backend\Classes\Controller;
use Cb\Trackdaybooking\Models\LocationFilterTrackday as LocationFilterTrackdayModel;
use Cb\Trackdaybooking\Traits\ResultBuilder;
use RainLab\Location\Models\Country;
use Cb\Car2db\Models\Make;
use Cb\Car2db\Models\Model;
use Cb\Car2db\Models\Serie;
use Cb\Car2db\Models\Trim;
use Request;
use Auth;

class Trackdays extends Controller
{
    use ResultBuilder;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $locationFilter = new LocationFilterTrackdayModel();
        $variants = $locationFilter->getByFilter(null, '', '', [''], null, '', 10, 1, new \stdClass());
        $variants = $this->prepareResult($variants, false);
        return $variants;
    }

    public function show(Request $request, $id) {
        $locationFilter = new LocationFilterTrackdayModel();
        $variants = $locationFilter->getByFilter(null, '', '', [''], null, '', 10, 1, new \stdClass(), false, $id);
        $variants = $this->prepareResult($variants, false);

        if ($variants['data'] and count($variants['data']) !== 0) {
           return ['data' => $variants['data'][0]];
        }
        return ['data' => null];
    }
}
