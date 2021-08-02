<?php namespace Cb\Pgmware\Models;

use Model;
use Cb\UserPlus\Models\Company as CompanyModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;

/**
 * Model
 */
class Vehicle extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_vehicles';

    public $attachOne = [];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        "company" => ["Cb\UserPlus\Models\Company", 'order' => 'name'],
        "vehicleType" => ["Cb\Pgmware\Models\VehicleType", 'order' => 'name']
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'description' => 'required|between:2,191',
        'license_plate' => 'required|between:2,64',
        'notes' => 'max:191',
        'drivetype' => 'max:191',
        'power' => 'required|numeric|min:0',
        'max_speed' => 'required|numeric|min:0',
        'noise' => 'required|numeric|min:0',
        'vehicle_type_id' => 'required'
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['description', 'notes', 'drivetype'];
}
