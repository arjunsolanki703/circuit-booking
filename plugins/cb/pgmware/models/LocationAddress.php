<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class LocationAddress extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_location_address';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:2,191',
        'additional' => 'required|between:0,191',
        'street' => 'required|between:1,191',
        'zip' => 'required|max:20',
        'city' => 'required|between:2,191',
        'phone' => 'required|between:2,20',
        //'country_id' => 'required|integer|exists:rainlab_location_countries,id',
        'fax' => 'max:20',
        'url' => 'max:191|url',
        'email' => 'max:191|email',
        'gps_lat' => 'numeric',
        'gps_lon' => 'numeric',
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'additional',
        'street',
        'zip',
        'city',
        'phone',
        'fax',
        'url',
        'email',
        'gps_lat',
        'gps_lon',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
        "location" => ["Cb\Pgmware\Models\Location"]
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name', 'city', 'additional', 'street'];
}
