<?php

namespace Cb\TabTrackDayBookings\Components;

use Flash;
use Lang;
use Validator;
use ValidationException;
use ApplicationException;
use RainLab\User\Components\Account as UserAccount;
use Responsiv\Currency\Models\Currency;
use Cb\Trackdaybooking\Models\OrderTrackday;
use Illuminate\Database\Eloquent\Builder;
use Cb\Pgmware\Models\Variant;
use Cb\Trackdaybooking\Models\Trackday;
use Cb\Booking\Models\Booking;
use Carbon\Carbon;
use Cb\Pgmware\Models\Continent;
use RainLab\Location\Models\Country;
use Cb\Pgmware\Models\Location;
use Cb\Pgmware\Models\VehicleType;
use Cb\Booking\Models\BookingStatus;
use Cb\Booking\Models\BookingType;
use Cb\Trackdaybooking\Models\TrackdayCapacity;
use Cb\Booking\Models\BookingParticipantBooking;

class TrackDayBookings extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name' => 'TrackDayBookings Component',
            'description' => '',
        ];
    }

    public function onRun()
    {
        parent::onRun();

        if (empty($this->user())) {
            return;
        }

        $this->addJs('/plugins/cb/tabtrackdaybookings/assets/flatpickr/js.js');
        $this->addCss('/plugins/cb/tabtrackdaybookings/assets/flatpickr/css.css');

        $this->addJs('/plugins/cb/tabtrackdaybookings/assets/datepicker/js.js');
        $this->addCss('/plugins/cb/tabtrackdaybookings/assets/datepicker/css.css');

        $this->addJs('/plugins/cb/tabtrackdaybookings/assets/clockpicker/js.js');
        $this->addCss('/plugins/cb/tabtrackdaybookings/assets/clockpicker/css.css');

        $this->addJs('/plugins/cb/trackdaybooking/assets/modal/js.js');
        $this->addCss('/plugins/cb/trackdaybooking/assets/modal/css.css');

        $this->onTable();
    }

    public function onTable()
    {
        $user = $this->user();
        if (isset($user) && isset($user->id)) {
            $this->reloadTable();
        }

        $this->page['tempPath'] = temp_path();
        $this->page['mode'] = '';

        $this->onModel();
    }

    public function onModel()
    {
        $trackday = Trackday::whereHas('company', function (Builder $q) {
            $q->where('user_id', $this->user()->id);
        })->get();


        $continents = Continent::all();
        $currency = Currency::all();
        $vehicle_type = VehicleType::all();

        $this->page['model'] = [
            'trackdays' => $trackday,
            'continents' => $continents,
            'currency' => $currency,
            'vehicle_type' => $vehicle_type,
        ];
    }

    public function onSaveModel()
    {
        $validation = \Illuminate\Support\Facades\Validator::make(request()->all(), [
            'agree' => ['required'],
            'trackday_id' => ['required'],
            'variant_id' => ['required'],
            'trackday_name' => ['required'],
            'vat_value' => 'required|between:0,2',
            'start_data_time' => ['required'],
            'end_data_time' => ['required'],
            'price_per_person' => ['required'],
            'currency_id_step_2' => ['required'],
        ]);

        if ($validation->fails()) {
            throw new \October\Rain\Exception\ValidationException($validation);
        }

        $bookingStatus = BookingStatus::whereRaw('lower(`name`) = ?', 'confirmed')->first()->id ?? 0;

        $bookingType = BookingType::where('pluginname', 'tabtrackdaybookings.trackday')->first();
        if (empty($bookingType)) {
            $bookingType = (new BookingType())->forceFill(['pluginname' => 'tabtrackdaybookings.trackday', 'name' => 'trackday']);
            $bookingType->save();
        }

        $booking = (new Booking())->forceFill([
            'number_prefix' => 'TD',
            'number' => now()->format('YmdHis'),
            'description' => ' ',
            'booking_status_id' => $bookingStatus,
            'booking_type_id' => $bookingType->id,
        ]);

        $booking->save();

        $orderTrackday = (new OrderTrackday())->forceFill([
            'booking' => $booking->id,
            'currency_id' => request()->currency_id_step_2,
            'trackday_id' => request()->trackday_id,
            'variant_id' => request()->variant_id,
            'title' => request()->trackday_name,
            'vat_value' => request()->vat_value,
            'start_date' => request()->start_data_time,
            'end_date' => request()->end_data_time,
            'price' => request()->price_per_person,
            'description' => ' ',
        ]);

        $orderTrackday->save();

        $trackdayCapacity = (new TrackdayCapacity())->forceFill([
            'amount' => request()->price_per_person,
            'order_trackday_id' => $orderTrackday->id,
        ]);

        $trackdayCapacity->save();

    }

    public function getBaseModel()
    {
        $user = $this->user();

        if (empty($user->company)) {
            return;
        }

        return OrderTrackday::whereHas('trackday', function (Builder $q) {
            $q->whereHas('company', function (Builder $q) {
                $q->where('id', $this->user()->company->id);
            });
        })->whereNull('deleted_at');

    }

    private function reloadTable()
    {
        $this->page['mode'] = "";

        $this->page['items'] = $this->getBaseModel()->get();
    }


    public function onStep1Country()
    {
        $country = Country::where('cb_continent_id', post('id'))->get();

        $this->page['country'] = $country;
    }

    public function onStep1Location()
    {
        $location = Location::where('country_id', post('id'))->get();

        $this->page['location'] = $location;
    }

    public function onStep1Variant()
    {
        $variant = Variant::where('location_id', post('id'))->get();

        $this->page['variant'] = $variant;
    }


    /*
     * ajax update bookble
     */
    public function onTrackDayBookingsUpdateBookable()
    {
        $trackDayBooking = $this->getBaseModel()->where('id', post('id'))->first();

        if (empty($trackDayBooking)) {
            return;
        }

        $trackDayBooking->trackday->forceFill([
            'bookable' => !$trackDayBooking->trackday->bookable,
        ])->save();

        $this->reloadTable();
    }

    /**
     * view page
     */
    public function onViewTrackDayBooking()
    {
        $item = $this->getBaseModel()->where('id', post('id'))->first();

        $this->page['item'] = $item;

    }

    /**
     * Edit TrackDayBooking
     */
    public function onEditTrackDayBooking()
    {
        $item = $this->getBaseModel()->where('id', post('id'))->first();

        $start_date = Carbon::parse($item->start_date);
        $this->page['start_date'] = $start_date->format('Y-m-d');
        $this->page['start_date_time'] = $start_date->format('H:i');

        $end_date = Carbon::parse($item->start_date);
        $this->page['end_date'] = $end_date->format('Y-m-d');
        $this->page['end_date_time'] = $end_date->format('H:i');

        $this->page['item'] = $item;

        $this->page['variants'] = Variant::all();

        $this->page['trackdays'] = Trackday::all();

        $this->page['currencys'] = Currency::all();

        $this->page['bookings'] = Booking::all();

        if (empty(post('id'))) {
            $this->page['mode'] = 'add';
        } else {
            $this->page['mode'] = 'edit';
            $this->page['orderTrackdayParticipantCount'] = BookingParticipantBooking::whereHas('booking', function (Builder $q) {
                $q->orWhere('booking_status_id', 3);
            })->orWhere('participant_type_id', 2)
                ->where('booking_id', $item->id)
                ->count();
        }
    }

    /**
     * save data
     *
     * @throws \October\Rain\Exception\ValidationException
     */
    public function onTrackDayBookingSave()
    {
        $data = request()->only([
            'title',
            'variant_id',
            'description',
            'price',
            'currency_id',
            'vat_value',
            'booking_id',
        ]);

        $start_date = request()->start_date . ' ' . request()->start_date_time;
        $end_date = request()->end_date . ' ' . request()->end_date_time;

        if (!empty(trim($start_date))) {
            $data['start_date'] = $start_date . ':00';
        }

        if (!empty(trim($end_date))) {
            $data['end_date'] = $end_date . ':00';
        }

        $validation = \Illuminate\Support\Facades\Validator::make($data, [
            'vat_value' => 'required|between:0,2',
            'price' => ['required'],
            'start_date' => 'date_format:Y-m-d H:i:s',
            'end_date' => 'date_format:Y-m-d H:i:s',
        ]);

        if ($validation->fails()) {
            throw new \October\Rain\Exception\ValidationException($validation);
        }


        if (post('id') == null) {
            $trackday = (new OrderTrackday())->forceFill($data);
            $trackday->save();
        } else {
            $trackday = $this->getBaseModel()->where('id', post('id'))->first();
            $trackday->forceFill($data)->save();
        }

        $this->reloadTable();
    }

    /**
     * delete
     */
    public function onDeleteTrackDayBooking()
    {
        $trackday = $this->getBaseModel()->where('id', post('id'))->first();

        $trackday->forceFill(['deleted_at' => now()])->save();

        $trackday->booking->forceFill(['booking_status_id' =>2])->save();

        $this->reloadTable();
    }
}
