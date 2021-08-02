<?php namespace Cb\Trackdaybooking\Models;

use Model;

/**
 * TrackdayCapacity Model
 */
class TrackdayCapacity extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_trackdaybooking_trackday_capacities';

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
        'order_trackday' => 'cb\trackdaybooking\models\OrderTrackday',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
