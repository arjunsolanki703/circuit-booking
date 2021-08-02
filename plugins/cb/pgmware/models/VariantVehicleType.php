<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class VariantVehicleType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_lnk_variant_vehicle_types';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
