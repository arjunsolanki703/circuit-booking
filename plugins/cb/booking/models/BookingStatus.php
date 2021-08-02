<?php namespace Cb\Booking\Models;

use Model;

/**
 * BookingStatus Model
 */
class BookingStatus extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_booking_booking_statuses';

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
    public $hasMany = [
        'bookings' => 'cb\booking\models\Booking',
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
