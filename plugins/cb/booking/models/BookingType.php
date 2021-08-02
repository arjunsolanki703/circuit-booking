<?php namespace Cb\Booking\Models;

use Model;

/**
 * BookingType Model
 */
class BookingType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_booking_booking_types';

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
