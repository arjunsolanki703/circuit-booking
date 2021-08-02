<?php namespace Cb\Pgmware\Models;

use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Continent as ContinentModel;
use Cb\Pgmware\Models\Grade as GradeModel;
use Cb\Pgmware\Models\Lastminute as LastminuteModel;
use Cb\Pgmware\Models\Location as LocationModel;
use Cb\Pgmware\Models\LocationAddress as LocationAddressModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\VariantType as VariantTypeModel;
use Cb\Pgmware\Models\VariantVehicleType as VariantVehicleTypeModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;
use Cb\Pgmware\Models\LocationFilterBase as LocationFilterBase;

use RainLab\Location\Models\Country as CountryModel;
use Responsiv\Currency\Models\Currency as CurrencyModel;

class LocationFilterCircuits extends LocationFilterBase
{

    protected function queryFilterSelect(&$variants, $extraFilterClass = null, $onlyGeo = false) {
        $c = (new CountryModel)->table;
        $con = (new ContinentModel)->table;
        $l = $this->table;
        $v = (new VariantModel)->table;
        $vt = (new VariantTypeModel)->table;
        $addr = (new LocationAddressModel)->table;
        $g = (new GradeModel)->table;

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
                \DB::raw("{$c}.cb_slug AS country_slug"),
                \DB::raw("{$c}.name AS country_name"),
                \DB::raw("{$con}.code AS continent_code")
            );
        }
        $variants->groupBy($l.'.id');
    }

    protected function variantsFinalSelect(&$variants, &$Table)
    {
        $l = $this->table;
        $variants->select(\DB::raw("count(DISTINCT {$l}.id) AS count"));
    }
}