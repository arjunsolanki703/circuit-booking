<?php namespace Cb\Pgmware\Models;

use Model;
use Lang;
use Auth;
use ValidationException;
use Cb\Pgmware\Models\BookingType as BookingTypeModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;

/**
 * Model
 */
class BookingVariant extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Purgeable;
    use \October\Rain\Database\Traits\Nullable;

    protected $dates = ['deleted_at'];

    public $countVehicles = [
        '1 - 8',
        '9 - 16',
        '17 - 24',
        '25 - 31'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_bookings_variants';

    public $belongsTo = [
        'booking_type' => ['Cb\Pgmware\Models\BookingType', 'key' => 'booking_type_id'],
        'variant' => ['Cb\Pgmware\Models\Variant'],
        'vehicle_type' => ['Cb\Pgmware\Models\VehicleType', 'key' => 'vehicle_type_id'],
        'user' => [\October\Rain\Auth\Models\User::class],
        'location' => ['Cb\Pgmware\Models\Location', 'key' => 'variant_id'],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'booking_type_id' => 'required|exists:cb_pgmware_booking_types,id',
        'variant_id' => 'required|exists:cb_pgmware_variants,id|exists:cb_pgmware_variants,id',
        'vehicle_type_id' => 'required|exists:cb_pgmware_vehicle_types,id',
        'vehicles_count' => 'required',
        'start_date' => 'required|date|after:today|before_or_equal:end_date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'track_start_date' => '',
        'track_end_date' => '',
        'comment' => 'max:5000',
        'garage' => 'nullable|numeric|min:0',
        'meeting_rooms' => 'nullable|numeric|min:0',
        'consecutive_days' => 'required|numeric|min:0',
        'tear_down_days' => 'nullable|numeric|min:0',
        'setup_days' => 'nullable|numeric|min:0',
        'time_keeping' => '',
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'booking_type_id',
        'variant_id',
        'vehicle_type_id',
        'vehicles_count',
        'start_date',
        'end_date',
        'track_start_date',
        'track_end_date',
        'comment',
        'garage',
        'meeting_rooms',
        'time_keeping',
        'agree',
        'consecutive_days',
        'tear_down_days',
        'setup_days'
    ];

    protected $purgeable = ['agree'];

    /**
     * @var array Nullable attributes.
     */
    protected $nullable = ['meeting_rooms', 'garage', 'tear_down_days', 'setup_days'];

    protected $appends = ['username_surname'];

    public function getUsernameSurnameAttribute($val)
    {
        if (empty($this->user)){
            return '';
        }

        return $this->user->name . ' '. $this->user->surname;
    }

    public function user()
    {
        return $this->belongsTo(\October\Rain\Auth\Models\User::class);
    }

    public function scopeMakeForProfile($query, $options = [])
    {
        return $query->limit(50)
            ->orderBy('start_date', 'DESC')
            ->with('variant.location');
    }

    public function getBookedDates($variantId)
    {
        return $this->select('start_date', 'end_date')
            ->where('variant_id', $variantId)
            ->where(\DB::raw('DATE(start_date)'), '>', date('Y-m-d'))
            ->orderBy('start_date')
            ->get();
    }

    public function beforeCreate()
    {
        $this->start_date = date('Y-m-d', strtotime($this->start_date));
        $this->end_date = date('Y-m-d', strtotime($this->end_date));
        if ($this->track_start_date) {
            $this->track_start_date = date('Y-m-d', strtotime($this->track_start_date));
        }
        if ($this->track_end_date) {
            $this->track_end_date = date('Y-m-d', strtotime($this->track_end_date));
        }

        $this->user_id = Auth::getUser()->id;
        // check that time is not booked yet
        $count = $this->where('variant_id', $this->variant_id)
            ->where(function($q) {
                $d1 = $this->start_date;
                $d2 = $this->end_date;
                $q->whereRaw("DATE(start_date) BETWEEN DATE('{$d1}') AND DATE('{$d2}')")
                    ->orWhereRaw("DATE(end_date) BETWEEN DATE('{$d1}') AND DATE('{$d2}')");
            })->count();
        $errors = [];
        if ($count > 0) {
            $errors['start_date'] = Lang::get('cb.pgmware::lang.componentBooking.dateBooked');
            $errors['end_date'] = Lang::get('cb.pgmware::lang.componentBooking.dateBooked');
        }
        $variant = VariantModel::where('id', $this->variant_id)->first();

        if (strtotime($this->start_date) < time($variant->location->open_from)) {
            $errors['start_date'] = Lang::get('cb.pgmware::lang.componentBooking.dateOutTheLimit');
        }
        if (strtotime($this->end_date) < time($variant->location->open_to)) {
            $errors['end_date'] = Lang::get('cb.pgmware::lang.componentBooking.dateOutTheLimit');
        }
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $this->start_date);
        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $this->end_date);
        $diff_in_days = $end->diffInDays($start) + 1;
        if (intval($this->consecutive_days) > $diff_in_days) {
            $errors['consecutive_days'] = Lang::get('cb.pgmware::lang.componentBooking.selectDaysLessThanPeriod');
        }
        if (intval($this->tear_down_days) > $diff_in_days) {
            $errors['tear_down_days'] = Lang::get('cb.pgmware::lang.componentBooking.selectDaysLessThanPeriod');
        }
        if (intval($this->setup_days) > $diff_in_days) {
            $errors['setup_days'] = Lang::get('cb.pgmware::lang.componentBooking.selectDaysLessThanPeriod');
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
