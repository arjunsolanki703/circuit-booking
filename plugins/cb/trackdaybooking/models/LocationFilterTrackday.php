<?php namespace Cb\Trackdaybooking\Models;

use Cb\Pgmware\Models\Continent as ContinentModel;
use Cb\Pgmware\Models\Grade as GradeModel;
use Cb\Pgmware\Models\LocationAddress as LocationAddressModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\VariantType as VariantTypeModel;
use Cb\Pgmware\Models\LocationFilterBase as LocationFilterBase;
use Cb\Trackdaybooking\Models\OrderTrackday as OrderTrackdayModel;
use Cb\Trackdaybooking\Models\Trackday as TrackdayModel;
use Cb\Booking\Models\Booking as BookingModel;
use RainLab\Location\Models\Country as CountryModel;
use Responsiv\Currency\Models\Currency as CurrencyModel;

class LocationFilterTrackday extends LocationFilterBase
{

    protected function queryFilterSelect(&$variants, $extraFilterClass = null, $onlyGeo = false) {
        $orderTrackday = (new OrderTrackdayModel())->table;
        $booking = (new BookingModel())->table;
        $variant = (new VariantModel)->table;
        $location = $this->table;
        $variantType = (new VariantTypeModel)->table;
        $currency = (new CurrencyModel)->table;
        $country = (new CountryModel)->table;
        $continent = (new ContinentModel)->table;
        $addr = (new LocationAddressModel)->table;
        $g = (new GradeModel)->table;
        $trackday = (new TrackdayModel)->table;
        $fileData = "system_files";

        $this->connectVariants($variants, $variant, $orderTrackday);
        $variants->join($booking, $booking.'.id', '=', $orderTrackday.'.booking_id');
        $variants->join($trackday, $trackday.'.id', '=', $orderTrackday.'.trackday_id');
        $variants->leftJoin($currency, $currency.'.id', '=', $orderTrackday.'.currency_id');
        $variants->leftJoin($fileData, $trackday.'.id', '=', $fileData.'.attachment_id');
        $variants->where($fileData.'.attachment_type', "=", "Cb\Trackdaybooking\Models\Trackday");
        $variants->where($booking.'.booking_status_id', '=', 3);

        if($extraFilterClass != null) {
            if (isset($extraFilterClass->price) && count($extraFilterClass->price) == 2) {
                $variants->whereBetween($orderTrackday.'.price', $extraFilterClass->price);
            }
            if (isset($extraFilterClass->startDate)) {
                $variants->where(\DB::raw('DATE('.$orderTrackday.'.start_date)'), '>=', $extraFilterClass->startDate);
            }
            if (isset($extraFilterClass->endDate)) {
                $variants->where(\DB::raw('DATE('.$orderTrackday.'.end_date)'), '<=', $extraFilterClass->endDate);
            }
            if (isset($extraFilterClass->vehicleType)) {
                $variants->whereIn($trackday.'.vehicle_type_id', $extraFilterClass->vehicleType);
            }
        }

        $filterByVehicle = $trackday.'.vehicle_type_id AS shar_vehicle_type_id';
        $selectTitle = $orderTrackday.'.title AS shar_title';
        $selectDescription = $orderTrackday.'.description AS shar_description';

        $variants->select(
            $location.'.*',
            \DB::raw("count({$variant}.id) as count_variants"),
            \DB::raw("min({$variant}.length) as min_length"),
            \DB::raw("max({$variant}.length) as max_length"),
            \DB::raw("GROUP_CONCAT({$variantType}.description) AS type"),
            $orderTrackday.'.id AS shar_id',
            $orderTrackday.'.start_date AS shar_start_date',
            $orderTrackday.'.end_date AS shar_end_date',
            $orderTrackday.'.price AS shar_price',
            $filterByVehicle,
            $selectTitle,
            $selectDescription,
            $currency.'.currency_code',
            $currency.'.currency_symbol',
            $variant.'.name as variant_name',
            $orderTrackday.'.title as order_trackday_title',
            $orderTrackday.'.description as order_trackday_description',
            $trackday.'.id as trackday_id',
            $fileData.'.disk_name',
            \DB::raw("{$country}.cb_slug AS country_slug"),
            \DB::raw("{$country}.name AS country_name"),
            \DB::raw("{$continent}.code AS continent_code"),
            \DB::raw("{$addr}.gps_lat AS lat"),
            \DB::raw("{$addr}.gps_lon AS lon")
        );

        $variants->groupBy($orderTrackday.'.id');
    }

    protected function variantsFinalSelect(&$variants, &$table)
    {
        $tm = (new OrderTrackdayModel())->table;
        $variants->leftJoin($tm, function($join) use ($tm, $table)
        {
            $join->on($tm.'.variant_id', '=', $table.'.id')
                ->whereNull($tm.'.deleted_at');
        });

        $otm = (new TrackdayModel())->table;
        $variants->Join($otm, function($join) use ($otm, $table, $tm)
        {
            $join->on($otm.'.id', '=', $tm.'.trackday_id')
                ->whereNull($otm.'.deleted_at');
        });

        $variants->select(\DB::raw("count(DISTINCT {$tm}.id) AS count"));
    }

    protected function connectVariants(&$variants, $table, $otm)
    {
        $variants->rightJoin($otm, function($join) use ($otm, $table)
        {
            $join->on($otm.'.variant_id', '=', $table.'.id')
                ->whereNull($otm.'.deleted_at');
        });
    }
}
