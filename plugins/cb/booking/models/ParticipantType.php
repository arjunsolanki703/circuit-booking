<?php namespace Cb\Booking\Models;

use Model;

/**
 * ParticipantType Model
 */
class ParticipantType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_booking_participant_types';

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
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
