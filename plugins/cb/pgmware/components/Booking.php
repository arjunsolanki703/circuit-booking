<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\BookingVariant as BookingModel;
use Cb\Pgmware\Models\BookingType as BookingTypeModel;
use Redirect;
use Response;
use BackendAuth;
use Cb\Pgmware\Components\Location;
use Flash;
use Lang;
use Request;
use Validator;
use ValidationException;

class Booking extends Location
{
    public $location;
    public $variant;
    public $dateStart;
    public $dateEnd;
    public $dateBooked;
    public $bookingTypes;
    public $vehicleTypes;
    public $countVehicles;

    public function componentDetails()
    {
        return [
            'name'        => 'cb.pgmware::lang.default.booking',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'variant' => [
                'title'       => 'cb.pgmware::lang.default.circuit',
                'description' => '',
                'default'     => '{{ :variant }}',
                'type'        => 'string',
            ],
            'slug' => [
                'title'       => 'slug',
                'description' => '',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'countrySlug' => [
                'title'       => 'slug',
                'description' => '',
                'default'     => '{{ :country }}',
                'type'        => 'string'
            ],
            'continentSlug' => [
                'title'       => 'continent',
                'description' => '',
                'default'     => '{{ :continent }}',
                'type'        => 'string'
            ],
            'startDateDefault' => [
                'title'       => 'startDate',
                'description' => '',
                'default'     => Request::input('start_day') ? date('Y-m-d', strtotime(Request::input('start_day'))) : '',
                'type'        => 'string'
            ],
            'endDateDefault' => [
                'title'       => 'endDate',
                'description' => '',
                'default'     => Request::input('end_day') ? date('Y-m-d', strtotime(Request::input('end_day'))) : '',
                'type'        => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->continent = $this->page['continent'] = $this->loadContinent();
        $this->country = $this->page['country'] = $this->loadCountry();
        $this->location = $this->page['location'] = $this->loadLocation();
        $this->variant = $this->page['variant'] = $this->loadVariant();
        if (!isset($this->variant->id)) {
            return;
        }
        $this->prepareDatesLimit();
        //$this->dateBooked = $this->page['dateBooked'] = (new BookingModel)->getBookedDates($this->variant->id);
        //echo '<pre>';print_r(count($this->dateBooked));die();
        $this->bookingTypes = $this->page['bookingTypes'] = BookingTypeModel::lists('id', 'name');
        $this->vehicleTypes = $this->page['vehicleTypes'] = $this->variant->vehicleTypes->lists('id', 'name');
        $this->countVehicles = $this->page['countVehicles'] = (new BookingModel)->countVehicles;
    }

    protected function prepareDatesLimit()
    {
        $this->dateStart = $this->location->open_from;
        if (strtotime($this->dateStart) < strtotime(date('Y-m-d'))) {
            $this->dateStart = date('Y-m-d');
        }
        $this->dateEnd = $this->page['dateEnd'] = $this->location->open_to ? date('Y-m-d', strtotime($this->location->open_to)) : null;
        $this->dateStart = $this->page['dateStart'] = $this->dateStart ? date('Y-m-d', strtotime($this->dateStart)) : null;

        $t = (new BookingModel)->getBookedDates($this->variant->id);
        $this->dateBooked = [];
        foreach ($t as $r) {
            $max = 0; // helper of forever loop
            if ($r->start_date && $r->end_date) {
                $s = strtotime($r->start_date);
                $e = strtotime($r->end_date);
                while ($s <= $e) {
                    $this->dateBooked[] = date('Y-m-d', $s);
                    $s = strtotime("+1 day", $s);
                    ++$max;
                    if ($max > 100) {
                        break;
                    }
                }
            }
        }
        $this->dateBooked = $this->page['dateBooked'] = array_unique($this->dateBooked);
    }

    protected function loadVariant()
    {
        $id = Request::input('variant') ? Request::input('variant') : $this->property('variant');

        $variant = new VariantModel;
        $variant = $variant->where('id', $id)->bookable();

        if ($variant->count() == 0 || !$variant = $variant->first()) {
            return $this->controller->run('404');
        }
        if (!isset($this->location->id) || $this->location->id != $variant->location_id) {
            return $this->controller->run('404');
        }

        $this->page->title = $variant->name;
        $this->page->meta_title = $variant->name;

        return $variant;
    }

    public function onBook()
    {
        try {
            $data = post();
            $rules = (new BookingModel)->rules;
            $rules['agree'] = 'required';
            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
            // TODO send email?
            if (BookingModel::create($data)) {
                return Response::json(['result' => 'OK']);
            } else {
                return Response::make('Unknown', 500);
            }
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }
}
