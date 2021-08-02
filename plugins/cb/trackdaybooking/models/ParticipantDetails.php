<?php namespace Cb\Trackdaybooking\Models;

use Model;

/**
 * participant_details Model
 */
class ParticipantDetails extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_trackdaybooking_participant_details';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    public $modelRules = [
        'licenseplate' => 'required|between:1,60',
        'trim_id' => 'required|exists:cb_car2db_trims,id',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'id',
        'licenseplate',
        'trim_id'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'bookingParticipant' => ['Cb\Booking\Models\BookingParticipant', 'key' => 'id', 'otherKey' => 'id']
    ];
    public $hasMany = [];
    public $belongsTo = [
        'trim' => ['Cb\Car2db\Models\Trim']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
