<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Lang;
use RainLab\Location\Models\Country as CountryModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;
use Cb\Pgmware\Models\VariantType as VariantTypeModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\LocationCircuitSharing as LocationModel;
use Cb\Pgmware\Models\Continent as ContinentModel;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Lastminute as LastminuteModel;
use Cb\Pgmware\Models\Grade as GradeModel;
use Request;

class Filter extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'cb.pgmware::lang.component.filter',
            'description' => ''
        ];
    }

    public $continent;
    public $country;
    public $vehicleType;
    public $grade;
    public $length;
    public $price;
    public $search;
    public $startDate;
    public $endDate;

    public $filteredVariants;
    public $perPage = 10;
    public $grades;

    public function defineProperties()
    {
        return [
            'isCircuitSharing' => [
                'title'       => 'cb.pgmware::lang.default.sharing',
                'description' => '',
                'default'     => Request::input('isCircuitSharing'),
                'type'        => 'checkbox',
            ],
            'isLastminute' => [
                'title'       => 'cb.pgmware::lang.default.lastminute',
                'description' => '',
                'default'     => Request::input('isLastminute'),
                'type'        => 'checkbox',
            ],
            'continent' => [
                'title'       => 'cb.pgmware::lang.default.continent',
                'description' => '',
                'default'     => Request::input('continent'),
                'type'        => 'dropdown',
                'placeholder' => 'cb.pgmware::lang.component.selectContinent',
            ],
            'country' => [
                'title'       => 'cb.pgmware::lang.default.country',
                'description' => '',
                'default'     => Request::input('country'),
                'type'        => 'dropdown',
                'depends'     => ['continent'],
                'placeholder' => 'cb.pgmware::lang.component.selectCountry',
            ],
            'vehicleType' => [
                'title'       => 'cb.pgmware::lang.default.vehicle',
                'description' => '',
                'default'     => Request::input('vehicleType'),
                'type'        => 'dropdown',
                'placeholder' => 'cb.pgmware::lang.component.selectVehicle',
            ],
            'grade' => [
                'title'       => 'cb.pgmware::lang.default.circuitGrade',
                'description' => '',
                'default'     => Request::input('grade'),
                'type'        => 'dropdown',
                'placeholder' => 'cb.pgmware::lang.default.circuitGrade',
            ],
            'length' => [
                'title'       => 'cb.pgmware::lang.component.circuitLength',
                'description' => '',
                'default'     => is_array(Request::input('length')) ? Request::input('length') : explode(';', Request::input('length')),
                'type'        => 'dropdown',
            ],
            'price' => [
                'title'       => 'cb.pgmware::lang.default.price',
                'description' => '',
                'default'     => is_array(Request::input('price')) ? Request::input('price') : explode(';', Request::input('price')),
                'type'        => 'dropdown',
            ],
            'selectorResult' => [
                'title'       => 'cb.pgmware::lang.component.selectorResult',
                'description' => '',
                'default'     => '#filtered-variants',
                'type'        => 'string',
            ],
            'search' => [
                'title'       => 'cb.pgmware::lang.component.search',
                'description' => '',
                'default'     => Request::input('search'),
                'type'        => 'string',
            ],
            'startDate' => [
                'title'       => 'startDate',
                'description' => '',
                'default'     => Request::input('start_date') ? date('Y-m-d', strtotime(Request::input('start_date'))) : '',
                'type'        => 'string'
            ],
            'endDate' => [
                'title'       => 'endDate',
                'description' => '',
                'default'     => Request::input('end_date') ? date('Y-m-d', strtotime(Request::input('end_date'))) : '',
                'type'        => 'string'
            ],
            'countriesOpened' => [
                'title'       => 'countriesOpened',
                'description' => '',
                'default'     => Request::input('countriesOpened'),
                'type'        => 'string'
            ]
        ];
    }

    public function getContinentOptions()
    {
        return ContinentModel::isEnabled()->orderBy('name')->lists('name', 'id');
    }

    public function getCountryOptions()
    {
        $continent = Request::input('continent');
        $list = [];
        if ($continent) {
            $list = CountryModel::isEnabled()->orderBy('name');
            if (is_array($continent)) {
                $list = $list->whereIn('cb_continent_id', $continent);
            } else {
                $list = $list->where('cb_continent_id', $continent);
            }
            $list = $list->lists('name', 'id');
        }
        return $list;
    }

    public function getVehicleTypeOptions()
    {
        return VehicleTypeModel::orderBy('name')->lists('name', 'id');
    }

    public function getVehicleTypeHelp()
    {
        return VehicleTypeModel::orderBy('name')->with('vehicle_icon')->get();
    }

    public function getGradeOptions()
    {
        return (new GradeModel())->lists('name', 'id');
    }

    public function getlengthOptions()
    {
        $min = VariantModel::where('bookable', '1')->min('length');
        $max = VariantModel::where('bookable', '1')->max('length');
        return ['min' => $min ? $min : 0, 'max' => ($max ? $max : 10)];
    }

    // TODO MK check if Cirquits
    public function getPriceOptions()
    {
        if ($this->property('isLastminute')) {
            $min = LastminuteModel::where('is_available', '1')->min('price');
            $max = LastminuteModel::where('is_available', '1')->max('price');
        } else {
            $min = CircuitSharingModel::where('is_available', '1')->min('price');
            $max = CircuitSharingModel::where('is_available', '1')->max('price');
        }
        return ['min' => $min ? $min : 0, 'max' => ($max ? $max : 10)];
    }

    public function getGradesObjects()
    {
        return GradeModel::with('grade_logo')->get()->keyBy('name');
    }

    public function onRun()
    {
    }

    public function initVarsWithPost()
    {
        $this->continent = Request::input('continent');
        $this->country = Request::input('country');
        $this->vehicleType = Request::input('vehicleType');
        $this->location = Request::input('location');
        $this->length = explode(';',  Request::input('length'));
        $this->price = explode(';',  Request::input('price'));
        $this->search = Request::input('search');
        $this->grade = Request::input('grade');
        $this->startDate = Request::input('start_date') ? date('Y-m-d', strtotime(Request::input('start_date'))) : '';
        $this->endDate = Request::input('end_date') ? date('Y-m-d', strtotime(Request::input('end_date'))) : '';
    }

    public function onGetFilter()
    {
        $this->initVarsWithPost();
        return ['content' => $this->renderPartial('@filter.htm')];
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
        $variants = $loc->getByFilter(
            $this->continent,
            $this->country,
            $this->grade,
            $this->length,
            $this->vehicleType,
            $this->search,
            $perPage,
            $page,
            $this->property('isCircuitSharing'),
            $this->price,
            $this->startDate,
            $this->endDate,
            $this->property('isLastminute'),
            $onlyGeo
        );
        $this->filteredVariants = $this->prepareResult($variants, $onlyGeo);
        $this->filteredVariants['superTotal'] = $loc->getFilterSuperTotal($this->property('isCircuitSharing'), $this->property('isLastminute'), $this->continent, $this->country);

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
            if (!$onlyGeo) {
                $r->vehicles = isset($vehicles[$r->id]) ? $vehicles[$r->id] : [];
                $r->type = implode(', ', array_filter(array_unique(explode(',', $r->type))));
                $r->min_length = number_format($r->min_length, 0, '.', ',');
                $r->max_length = number_format($r->max_length, 0, '.', ',');
                $r->grade = array_filter(array_unique(explode(',', $r->grade)));
                $r->fullAddress = $r->address->street . ', ' . $r->address->zip . ', ' . $r->address->city;
                unset($r->address);
            }
            $r->link = $this->getUrl($r);
            if ($this->property('isCircuitSharing') && !$onlyGeo) {
                $r->fullAddress = $r->name . ', ' . $r->fullAddress;
                $r->name = $r->shar_title;
            }
        }
        return $list->toArray();
    }

    protected function getUrl($r) {
        if ($this->property('isCircuitSharing')) {
            return $this->pageUrl('sharing/circuit-item', ['slug' => $r->slug]);
        }
        if ($this->property('isLastminute')) {
            return '#';
        }
        return $this->pageUrl('circuits/circuits-item', ["country" => $r->country_slug, "continent" => $r->continent_code, "slug" => $r->slug]);
    }

    public function onBookStripe() {

        if (empty(Request::input('circuit_sharing_id'))) {
            throw new ApplicationException('Invalid value');
        }

        $circuit_sharing_id = Request::input('circuit_sharing_id');
        $circuitSharinGm = CircuitSharingModel::where('id', $circuit_sharing_id)->first();

        if (empty($circuitSharinGm)) {
            throw new ApplicationException('Invalid value');
        }

        return StripeBinding::onBookStripeWithUser($circuitSharinGm->title, $circuitSharinGm->description, $circuitSharinGm->price*100, $circuitSharinGm->user_id);
    }
}
