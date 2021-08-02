<?php namespace Cb\Booking\Models;

use Model;

/**
 * BookingParticipantBooking Model
 */
class BookingParticipantBooking extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_booking_booking_participant_bookings';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'booking_id',
        'booking_participant_id',
        'participant_type_id',
        'booking_status_id'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'participant_type' => 'cb\booking\models\ParticipantType',
        'booking_participant' => 'cb\booking\models\BookingParticipant',
        'booking' => 'cb\booking\models\Booking',
        'booking_status' => 'cb\booking\models\BookingStatus',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
