<?php namespace Cb\Trackdaybooking\Models;

use Model;
use Illuminate\Support\Carbon;
use Cb\Booking\Models\BookingParticipantBooking;
use Illuminate\Database\Eloquent\Builder;
use Cb\Booking\Models\BookingStatus;

/**
 * OrderTrackday Model
 */
class OrderTrackday extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_trackdaybooking_order_trackdays';

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
        'trackdaycapacitys' => 'cb\trackdaybooking\models\TrackdayCapacity',
    ];
    public $belongsTo = [
        'currency' => 'responsiv\currency\models\Currency',
        'trackday' => 'cb\trackdaybooking\models\Trackday',
        'booking' => 'cb\booking\models\Booking',
        'variant' => 'cb\pgmware\models\Variant',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getStartDate()
    {
        return Carbon::parse($this->start_date)->format('Y-m-d');
    }

    public function getEndDate()
    {
        return Carbon::parse($this->end_date)->format('Y-m-d');
    }

    public function getCountBookingParticipantBooking()
    {
        $bookingStatus = BookingStatus::whereRaw('lower(`name`) = ?', 'confirmed')->first()->id ?? 0;

        return BookingParticipantBooking::whereHas('booking', function (Builder $q) use ($bookingStatus) {
            $q->orWhere('booking_status_id', $bookingStatus->id ?? '');
        })->where('booking_id', $this->id ?? '')->count();
    }
}
