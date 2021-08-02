<?php namespace Cb\UserPlus\Models;

use Model;
use RainLab\Location\Models\Country as CountryModel;

/**
 * Model
 */
class Company extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_userplus_companies';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:2,100',
        'address' => 'required|between:1,255',
        'zip' => 'required|max:20',
        'city' => 'required|between:2,100',
        'phone' => 'required|between:2,20',
        'country_id' => 'required|integer|exists:rainlab_location_countries,id',
        'fax' => 'max:20',
        'url' => 'max:255',
        'vat_number' => 'max:20'
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'address',
        'zip',
        'city',
        'phone',
        'country_id',
        'user_id',
        'fax',
        'url',
        'vat_number',
        'user_id'
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        "user" => ["RainLab\User\Models\User"],
        "country" => ["RainLab\Location\Models\Country", 'conditions' => 'is_enabled = 1']
    ];

    public $attachOne = [
        'termsfile' => 'System\Models\File'
    ];

}
