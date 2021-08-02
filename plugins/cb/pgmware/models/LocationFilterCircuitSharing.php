<?php namespace Cb\Pgmware\Models;

use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Continent as ContinentModel;
use Cb\Pgmware\Models\Grade as GradeModel;
use Cb\Pgmware\Models\LocationAddress as LocationAddressModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\VariantType as VariantTypeModel;
use Cb\Pgmware\Models\LocationFilterBase as LocationFilterBase;

use RainLab\Location\Models\Country as CountryModel;
use Responsiv\Currency\Models\Currency as CurrencyModel;

class LocationFilterCircuitSharing extends LocationFilterBase
{

    protected function queryFilterSelect(&$variants, $extraFilterClass = null, $onlyGeo = false) {
        $table = (new CircuitSharingModel)->table;
        $v = (new VariantModel)->table;
        $l = $this->table;
        $vt = (new VariantTypeModel)->table;
        $currency = (new CurrencyModel)->table;
        $c = (new CountryModel)->table;
        $con = (new ContinentModel)->table;
        $addr = (new LocationAddressModel)->table;
        $g = (new GradeModel)->table;
        $this->connectVariants($variants, $v, $table);
        $variants->leftJoin($currency, $currency.'.id', '=', $table.'.currency_id');

        if ($extraFilterClass->price && count($extraFilterClass->price) == 2) {
            $variants->whereBetween($table.'.price', $extraFilterClass->price);
        }
        if ($extraFilterClass->startDate) {
            $variants->where(\DB::raw('DATE('.$table.'.start_date)'), '>=', $extraFilterClass->startDate);
        }
        if ($extraFilterClass->endDate) {
            $variants->where(\DB::raw('DATE('.$table.'.end_date)'), '<=', $extraFilterClass->endDate);
        }
        if ($extraFilterClass->vehicleType) {
            $variants->whereIn($table.'.vehicle_type_id', $extraFilterClass->vehicleType);
        }
        $filterByVehicle = $table.'.vehicle_type_id AS shar_vehicle_type_id';
        $selectTitle = $table.'.title AS shar_title';
        $selectDescription = $table.'.description AS shar_description';

        if ($onlyGeo) {
            $variants->select(
                $l.'.name',
                $l.'.slug',
                \DB::raw("{$c}.cb_slug AS country_slug"),
                \DB::raw("{$c}.name AS country_name"),
                \DB::raw("{$con}.code AS continent_code"),
                \DB::raw("{$addr}.gps_lat AS gps_lat"),
                \DB::raw("{$addr}.gps_lon AS gps_lon")
            );
        } else {
            $variants->select(
                $l.'.*',
                \DB::raw("count({$v}.id) as count_variants"),
                \DB::raw("min({$v}.length) as min_length"),
                \DB::raw("max({$v}.length) as max_length"),
                \DB::raw("GROUP_CONCAT( IF(DATE({$v}.fia_grade_valid_before_date) >= CURDATE() OR {$v}.fia_grade_valid_before_date IS NULL, {$g}.name, NULL) ) AS grade"),
                \DB::raw("GROUP_CONCAT({$vt}.description) AS type"),
                $table.'.id AS shar_id',
                $table.'.start_date AS shar_start_date',
                $table.'.end_date AS shar_end_date',
                $table.'.price AS shar_price',
                $filterByVehicle,
                $selectTitle,
                $selectDescription,
                $currency.'.currency_code',
                $v.'.name as variant_name',
                \DB::raw("{$c}.cb_slug AS country_slug"),
                \DB::raw("{$c}.name AS country_name"),
                \DB::raw("{$con}.code AS continent_code")
            );
        }
        $variants->groupBy($table.'.id');
    }

    protected function variantsFinalSelect(&$variants, &$Table)
    {
        $shar = (new CircuitSharingModel)->table;
        $this->connectVariants($variants, $Table, $shar);
        $variants->select(\DB::raw("count(DISTINCT {$shar}.id) AS count"));
    }
}