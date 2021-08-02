<?php namespace Cb\Booking\Models;

use Model;

/**
 * BookingParticipant Model
 */
class BookingParticipant extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_booking_booking_participants';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    public $modelRules = [
        'name' => 'required|between:1,190',
        'surname' => 'required|between:1,190',
        'gender' => 'required|between:1,7',
        'email' => 'required|email|between:6,255',
        'zip' => 'required|between:1,190',
        'address' => 'required|between:1,190',
        'city' => 'required|between:1,190',
        'phone' => 'required|between:1,190',
        'country_id' => 'required|exists:rainlab_location_countries,id',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'surname',
        'gender',
        'email',
        'zip',
        'address',
        'city',
        'phone',
        'country_id'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'user' => 'rainlab\user\models\User',
        'country' => 'rainlab\location\models\Country',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
