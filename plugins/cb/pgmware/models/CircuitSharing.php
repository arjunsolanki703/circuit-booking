<?php namespace Cb\Pgmware\Models;

use Model;
use Auth;
use Cb\Pgmware\Models\Continent as ContinentModel;
use RainLab\Location\Models\Country as CountryModel;
use Cb\Pgmware\Models\Location as LocationModel;
use Cb\Pgmware\Models\Variant as VariantModel;

/**
 * Model
 */
class CircuitSharing extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Purgeable;

    protected $dates = ['deleted_at'];

    public $type = [
        'request' => 'Request',
        'offer' => 'Offer',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_circuit_sharing';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'booking_type_id' => 'required|exists:cb_pgmware_booking_types,id',
        'variant_id' => 'required|exists:cb_pgmware_variants,id|exists:cb_pgmware_variants,id',
        'vehicle_type_id' => 'required|exists:cb_pgmware_vehicle_types,id',
        'vehicles_count' => 'required',
        'start_date' => 'required|date|before_or_equal:end_date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'valid_before_date' => 'required|date',
        'description' => 'max:5000',
        'circuit_sharing_type' => 'required',
        'price' => 'required|numeric|min:0',
        'title' => 'required',
        'currency_id' => 'required'
    ];

    protected $purgeable = ['continent', 'country', 'location'];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'continent',
        'country',
        'location',
        'booking_type_id',
        'variant_id',
        'vehicle_type_id',
        'vehicles_count',
        'start_date',
        'end_date',
        'valid_before_date',
        'comment',
        'circuit_sharing_type',
        'price',
        'is_booked',
        'is_with_vat',
        'currency_id',
        'description',
        'title'
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        "currency" => ['Responsiv\Currency\Models\Currency'],
        'booking_type' => ['Cb\Pgmware\Models\BookingType', 'key' => 'booking_type_id'],
        'vehicle_type' => ['Cb\Pgmware\Models\VehicleType', 'key' => 'vehicle_type_id'],
        "variant" => ['Cb\Pgmware\Models\Variant'],
        "user" => ["RainLab\User\Models\User"],
    ];

    public function getContinentOptions()
    {
        if ($this->variant_id && !$this->continent && $this->id) {
            $variant = VariantModel::orderBy('name')->where('id', $this->variant_id)->first();
            $this->location = $variant->location_id;
            $location = LocationModel::orderBy('name')->where('id', $this->location)->first();
            $this->country = $location ? $location->country_id : null;
            $country = CountryModel::orderBy('name')->where('id', $this->country)->first();
            $this->continent = $country ? $country->cb_continent_id : null;
        }
        return ContinentModel::isEnabled()->lists('name', 'id');
    }
    public function getCountryOptions()
    {
        return CountryModel::orderBy('name')->isEnabled()->where('cb_continent_id', $this->continent)->lists('name', 'id');
    }
    public function getLocationOptions()
    {
        if (!$this->continent || !$this->country || !CountryModel::where('id', $this->country)->where('cb_continent_id', $this->continent)->first()) {
            return [];
        }
        return LocationModel::orderBy('name')->where('country_id', $this->country)->lists('name', 'id');
    }
    public function getVariantIdOptions()
    {
        if (!$this->continent || !$this->country || !$this->location || !LocationModel::where('country_id', $this->country)->where('id', $this->location)->first()) {
            return [];
        }
        return VariantModel::orderBy('name')->where('location_id', $this->location)->lists('name', 'id');
    }
    public function getCircuitSharingTypeOptions()
    {
        return $this->type;
    }

    public function beforeCreate()
    {
        $this->start_date = date('Y-m-d', strtotime($this->start_date));
        $this->end_date = date('Y-m-d', strtotime($this->end_date));
        $this->valid_before_date = date('Y-m-d', strtotime($this->valid_before_date));
        
        if (! $this->user_id) {
            $this->user_id = Auth::getUser()->id;
        }
    }

    public function getActiveRecords($locationId = null, $withRelations = false)
    {
        $query = $this->where(\DB::raw('DATE(valid_before_date)'), '>=', date('Y-m-d'))
            ->where('is_available', '1');
        if ($withRelations) {
            $query->with('variant', 'variant.location', 'variant.location.address');
        }
        if ($locationId) {
            $query->whereHas('variant', function($q) use ($locationId)
            {
                $q->where('location_id', '=', $locationId);
            });
        }
        return $query->get();
    }

    public function scopeMakeForProfile($query, $options = [])
    {
        return $query->limit(50)
            ->orderBy('is_available', 'DESC')
            ->orderBy('start_date', 'DESC');
    }

    public function getActiveRecordsCount($locationId)
    {
        $query = $this->where(\DB::raw('DATE(valid_before_date)'), '>=', date('Y-m-d'))
            ->where('is_available', '1');
        $query->whereHas('variant', function($q) use ($locationId)
        {
            $q->where('location_id', '=', $locationId);
        });
        return $query->count();
    }
}
