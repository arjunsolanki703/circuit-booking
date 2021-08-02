<?php namespace Cb\Booking\Models;

use Model;

/**
 * Booking Model
 */
class Booking extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_booking_bookings';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'booking_status' => 'cb\booking\models\BookingStatus',
        'booking_type' => 'cb\booking\models\BookingType'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
