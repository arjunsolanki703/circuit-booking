<?php namespace Cb\Pgmware\Components;

use Illuminate\Support\Facades\Log;
use Lang;
use Request;

use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Lastminute as LastminuteModel;
use Cb\Pgmware\Models\Location as LocationModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;
use Cb\Trackdaybooking\Models\LocationFilterTrackday as LocationFilterTrackdayModel;
use Cb\Trackdaybooking\Models\Trackday as TrackdayModel;
use Cb\Trackdaybooking\Traits\ResultBuilder;

class FilterTrackday extends Filter
{
    use ResultBuilder;

    public function componentDetails()
    {
        return [
            'name' => 'cb.pgmware::lang.component.filterCircuits',
            'description' => ''
        ];
    }

    public function onRun()
    {
    }

    public function init()
    {

    }

    public function onFilter()
    {
        $this->initVarsWithPost();
        $page = Request::input('page');
        $page = $page ? $page : 1;
        $perPage = $this->perPage;
        if (Request::input('perPage')) {
            $perPage = Request::input('perPage');
        }
        $onlyGeo = false;
        if (Request::input('onlyGeo')) {
            $onlyGeo = true;
        }

        $extraFilderClass = new \stdClass();

        $locationFilter = new LocationFilterTrackdayModel();

        $variants = $locationFilter->getByFilter(
            $this->continent,
            $this->country,
            $this->grade,
            $this->length,
            $this->vehicleType,
            $this->search,
            $perPage,
            $page,
            $extraFilderClass,
            $onlyGeo
        );

        $this->filteredVariants = $this->prepareResult($variants, $onlyGeo);
        $this->filteredVariants['superTotal'] = $locationFilter->getFilterSuperTotal($this->continent, $this->country);

        if (Request::input('isSearch')) {
            return [
                'result' => $this->renderPartial('@search.htm'),
                'json' => $this->filteredVariants
            ];
        } else {
            return [
                'filter' => $this->renderPartial('@filter.htm'),
                'result' => $this->renderPartial('@result.htm'),
                'filterHelper' => $this->renderPartial('@filter-helper.htm'),
                'json' => $this->filteredVariants
            ];
        }
    }
}
