<?php namespace Cb\Trackdaybooking\Models;

use Model;

/**
 * Trackday Model
 */
class Trackday extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_trackdaybooking_trackdays';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    public $rules = [
        'vat_value' => 'required|between:0,2',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'ordertrackdays' => 'cb\trackdaybooking\models\OrderTrackday',
    ];
    public $belongsTo = [
        'vehicle_type' => 'cb\pgmware\models\VehicleType',
        'currency' => 'responsiv\currency\models\Currency',
        'company' => 'cb\userplus\models\Company',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    public $attachMany = [];
}
