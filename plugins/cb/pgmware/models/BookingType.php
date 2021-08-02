<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class BookingType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_booking_types';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:2,191',
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name'];
}
