<?php namespace Cb\Pgmware\Components;

use Lang;
use Request;

use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Lastminute as LastminuteModel;
use Cb\Pgmware\Models\LocationFilterCircuitSharing as LocationModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;

class FilterSharing extends Filter
{
    public function componentDetails()
    {
        return [
            'name'        => 'FilterSharing',
            'description' => 'No description provided yet...'
        ];
    }

    protected function getUrl($r) {

        return $this->pageUrl('sharing/circuit-item', ['slug' => $r->slug]);
    }

    public function getPriceOptions()
    {
        $min = CircuitSharingModel::where('is_available', '1')->min('price');
        $max = CircuitSharingModel::where('is_available', '1')->max('price');
        return ['min' => $min ? $min : 0, 'max' => ($max ? $max : 10)];
    }

    public function onFilter()
    {
        $this->initVarsWithPost();
        $page = Request::input('page');
        $page = $page ? $page : 1;
        $perPage = $this->perPage;
        $loc = new LocationModel();
        if (Request::input('perPage')) {
            $perPage = Request::input('perPage');
        }
        $onlyGeo = false;
        if (Request::input('onlyGeo')) {
            $onlyGeo = true;
        }

        $extraFilderClass = new \stdClass();
        $extraFilderClass->price = $this->price;
        $extraFilderClass->startDate = $this->startDate;
        $extraFilderClass->endDate = $this->endDate;

        $variants = $loc->getByFilter(
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
        $this->filteredVariants['superTotal'] = $loc->getFilterSuperTotal($this->continent, $this->country);

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

    protected function prepareResult($list, $onlyGeo = false)
    {
        if (!$onlyGeo) {
            $ids = array_keys(($list->keyBy('id')->toArray()));
            $vehicles = (new VehicleTypeModel())->getByLocation($ids);
        }
        foreach ($list as &$r) {
            $r->link = $this->getUrl($r);
            if (!$onlyGeo) {
                $r->vehicles = isset($vehicles[$r->id]) ? $vehicles[$r->id] : [];
                $r->type = implode(', ', array_filter(array_unique(explode(',', $r->type))));
                $r->min_length = number_format($r->min_length, 0, '.', ',');
                $r->max_length = number_format($r->max_length, 0, '.', ',');
                $r->grade = array_filter(array_unique(explode(',', $r->grade)));
                $r->fullAddress = $r->address->street . ', ' . $r->address->zip . ', ' . $r->address->city;
                unset($r->address);
                $r->fullAddress = $r->name . ', ' . $r->fullAddress;
                $r->name = $r->shar_title;
            }
        }
        return $list->toArray();
    }
}
