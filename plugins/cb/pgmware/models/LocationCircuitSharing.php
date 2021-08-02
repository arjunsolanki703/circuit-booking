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
use RainLab\Location\Models\Country as CountryModel;
use Responsiv\Currency\Models\Currency as CurrencyModel;

/**
 * @deprecated LocationCircuitSharing sollte nicht mehr genutzt werden, sonder Location selbst
 * oder LocationFilterBase, wenn Filter notwendig sind. LocationFilterBase bietet die Möglichkeit durch Ableitung
 * den Filter selbst zu bestimmen. LocationCircuitSharing ist die ALTE all-in-one-Loesung und sollte vermieden werden!
 *
 */
class LocationCircuitSharing extends LocationModel
{

    public function getFilterSuperTotal($isCircuitSharing, $isLastminute = false, $continent = null, $country= null)
    {
        $c = (new CountryModel)->table;
        $l = $this->table;
        $v = (new VariantModel)->table;
        $variants = $this->leftJoin($v, function($join) use ($l, $v)
        { $join->on($l.'.id', '=', $v.'.location_id')->whereNull($l.'.deleted_at'); })
            ->where($v.'.bookable', '1')
            ->whereNull($v.'.deleted_at');

        $variants->leftJoin($c, function($join) use ($c, $l)
        {
            $join->on($l.'.country_id', '=', $c.'.id')
                ->where($c.'.is_enabled', '1');
        });
        if ($continent) {
            $variants->where($c.'.cb_continent_id', $continent);
        }
        if ($country && is_array($country) && count($country) > 0) {
            $variants->whereIn($l.'.country_id', $country);
        }

        if ($isCircuitSharing) {
            $shar = (new CircuitSharingModel)->table;
            $this->connectVariants($variants, $v, $shar);
            $variants->select(\DB::raw("count(DISTINCT {$shar}.id) AS count"));
        } elseif ($isLastminute) {
            $last = (new LastminuteModel)->table;
            $this->connectVariants($variants, $v, $last);
            $variants->select(\DB::raw("count(DISTINCT {$last}.id) AS count"));
        } else {
            $variants->select(\DB::raw("count(DISTINCT {$l}.id) AS count"));
        }

        $res = $variants->first();
        return $res->count;
    }

    public function getByFilter(
        $continent,
        $country,
        $grade,
        $length,
        $vehicleType,
        $search,
        $perPage,
        $page,
        $isCircuitSharing,
        $price,
        $startDate,
        $endDate,
        $isLastminute = false,
        $onlyGeo = false
    )
    {
        $c = (new CountryModel)->table;
        $con = (new ContinentModel)->table;
        $l = $this->table;
        $v = (new VariantModel)->table;
        $vehLink = (new VariantVehicleTypeModel)->table;
        $veh = (new VehicleTypeModel)->table;
        $vt = (new VariantTypeModel)->table;
        $addr = (new LocationAddressModel)->table;
        $g = (new GradeModel)->table;
        $variants = $this->joinFilterData()
            ->where($v.'.bookable', '1')
            ->whereNull($v.'.deleted_at');
        if ($continent) {
            $variants->where($c.'.cb_continent_id', $continent);
        }
        if ($country && is_array($country) && count($country) > 0) {
            $variants->whereIn($l.'.country_id', $country);
        }
        if ($grade) {
            $variants->where($v.'.grade_id', $grade);
            $variants->where(function ($query) use ($v) {
                $query->whereDate($v.'.fia_grade_valid_before_date', '>', date("Y-m-d"))
                    ->orWhereNull($v.'.fia_grade_valid_before_date');
            });
        }
        if ($length && count($length) == 2) {
            $variants->whereBetween($v.'.length', $length);
        }
        if ($vehicleType) {
            $variants->leftJoin($vehLink, function($join) use ($vehLink, $v)
            {
                $join->on($vehLink.'.variant_id', '=', $v.'.id')
                    ->whereNull($vehLink.'.deleted_at');
            });
            $variants->leftJoin($veh, function($join) use ($vehLink, $veh)
            {
                $join->on($vehLink.'.vehicle_type_id', '=', $veh.'.id')
                    ->whereNull($veh.'.deleted_at');
            });
            $variants->whereIn($veh.'.id', $vehicleType);
        }
        $search = trim($search);
        if ($search) {
            $variants->where($l.'.name', 'like', '%'.$search.'%');
        }

        if ($isCircuitSharing || $isLastminute) {
            $this->queryFilterForSharing($variants, $price, $startDate, $endDate, $vehicleType, $isLastminute, $onlyGeo);
        } else {
            $this->queryFilterSelect($variants, $onlyGeo);
        }
        if (!$onlyGeo) {
            $variants->with("location_preview", "location_scheme");
        }

        $variants->orderBy($l.'.name');
        $variants = $variants->paginate($perPage, $page);
        return $variants;
    }

    protected function queryFilterSelect(&$variants, $onlyGeo = false) {
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

    private function queryFilterForSharing(&$variants, $price, $startDate, $endDate, $vehicleType, $isLastminute = false, $onlyGeo = false)
    {
        $table = (new CircuitSharingModel)->table;
        if ($isLastminute) {
            $table = (new LastminuteModel)->table;
        }
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
        if ($price && count($price) == 2) {
            $variants->whereBetween($table.'.price', $price);
        }
        if ($startDate) {
            $variants->where(\DB::raw('DATE('.$table.'.start_date)'), '>=', $startDate);
        }
        if ($endDate) {
            $variants->where(\DB::raw('DATE('.$table.'.end_date)'), '<=', $endDate);
        }
        if ($vehicleType && !$isLastminute) {
            $variants->whereIn($table.'.vehicle_type_id', $vehicleType);
        }
        $filterByVehicle = $table.'.vehicle_type_id AS shar_vehicle_type_id';
        $selectTitle = $table.'.title AS shar_title';
        $selectDescription = $table.'.description AS shar_description';
        if ($isLastminute) {
            $filterByVehicle = \DB::raw('NULL AS shar_vehicle_type_id');
            $selectTitle = \DB::raw("'' AS shar_title");
            $selectDescription = \DB::raw("'' AS shar_description");
        }

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
}