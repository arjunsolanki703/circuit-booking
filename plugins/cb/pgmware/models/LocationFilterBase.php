<?php namespace Cb\Pgmware\Models;

use DB;
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

abstract  class LocationFilterBase extends LocationModel
{
    protected abstract function variantsFinalSelect(&$variants, &$Table);

    public function getFilterSuperTotal($continent = null, $country= null)
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

        $this->variantsFinalSelect($variants, $v);

        $res = $variants->first();
        return $res->count;
    }

    protected abstract function queryFilterSelect(&$variants, $extraFilterClass = null, $onlyGeo = false);

    /**
     * @param $continent
     * @param $country
     * @param $grade
     * @param $length
     * @param $vehicleType
     * @param $search
     * @param $perPage
     * @param $page
     * @param $extraFilterClass { $isCircuitSharing :bool, $price :float, $startDate x, $endDate y, $isLastminute :bool }
     * @param bool $onlyGeo
     * @return mixed
     */
    public function getByFilter(
        $continent,
        $country,
        $grade,
        $length,
        $vehicleType,
        $search,
        $perPage,
        $page,
        $extraFilterClass,
        $onlyGeo = false,
        $id = null
    )
    {
        $c = (new CountryModel)->table;
        $l = $this->table;
        $v = (new VariantModel)->table;
        $vehLink = (new VariantVehicleTypeModel)->table;
        $veh = (new VehicleTypeModel)->table;

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

        $extraFilterClass->vehicleType = $vehicleType;

        $this->queryFilterSelect($variants, $extraFilterClass, $onlyGeo);

        if ($id) {
            $variants->where($l.'.id', $id);
        }

        if (!$onlyGeo) {
            $variants->with("location_preview", "location_scheme");
        }

        Db::connection()->enableQueryLog();

        $variants->orderBy($l.'.name');
        $variants = $variants->paginate($perPage, $page);
        $queries = Db::getQueryLog();
        Db::connection()->disableQueryLog();

        return $variants;
    }


}
