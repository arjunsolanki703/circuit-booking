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
class Lastminute extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Purgeable;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_lastminute';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'variant_id' => 'required|exists:cb_pgmware_variants,id|exists:cb_pgmware_variants,id',
        'start_date' => 'required|date|after:today|before_or_equal:end_date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'valid_before_date' => 'required|date|after:today',
        'description' => 'max:5000',
        'price' => 'required|numeric|min:0',
        'currency_id' => 'required'
    ];

    protected $purgeable = ['continent', 'country', 'location'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        "currency" => ['Responsiv\Currency\Models\Currency'],
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

    public function beforeCreate()
    {
        $this->start_date = date('Y-m-d', strtotime($this->start_date));
        $this->end_date = date('Y-m-d', strtotime($this->end_date));
        $this->valid_before_date = date('Y-m-d', strtotime($this->valid_before_date));
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
