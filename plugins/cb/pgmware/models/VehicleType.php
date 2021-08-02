<?php namespace Cb\Pgmware\Models;

use Model;
use RainLab\Location\Models\Country as CountryModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;
use Cb\Pgmware\Models\VariantVehicleType as VariantVehicleTypeModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\Location as LocationModel;
use Cb\Pgmware\Models\Continent as ContinentModel;
use Cb\Pgmware\Models\VariantType as VariantTypeModel;

/**
 * Model
 */
class VehicleType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_vehicle_types';

    public $attachOne = [
        'vehicle_icon' => 'System\Models\File'
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:2,191',
        'icon' => 'max:64',
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'icon',
        'order'
    ];

    public function getByLocation($ids)
    {
        $vehLink = (new VariantVehicleTypeModel)->table;
        $v = (new VariantModel)->table;
        $veh = (new VehicleTypeModel)->table;
        $tmp = VehicleTypeModel::select($veh.'.*', $v.'.location_id')
            ->join($vehLink, function($join) use ($vehLink, $veh)
            {
               $join->on($vehLink.'.vehicle_type_id', '=', $veh.'.id')
               ->whereNull($vehLink.'.deleted_at');
            })
            ->join($v, function($join) use ($vehLink, $v, $ids)
            {
               $join->on($vehLink.'.variant_id', '=', $v.'.id')
               ->whereNull($v.'.deleted_at')
               ->whereIn('location_id', $ids);
            })
            ->with('vehicle_icon')
            ->whereNull($v.'.deleted_at')->get();
        $vehicles = [];
        foreach ($tmp as $r) {
            $vehicles[$r->location_id][$r->id] = $r;
        }
        return $vehicles;
    }
}
