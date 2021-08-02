<?php namespace Cb\Pgmware\Models;

use Model;
use RainLab\Location\Models\Country as CountryModel;
use Cb\Pgmware\Models\LocationAddress as LocationAddressModel;
use Cb\Pgmware\Models\Grade as GradeModel;

use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;
use Cb\Pgmware\Models\Continent as ContinentModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\VariantType as VariantTypeModel;
use Cb\Pgmware\Models\VariantVehicleType as VariantVehicleTypeModel;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Lastminute as LastminuteModel;
use Responsiv\Currency\Models\Currency as CurrencyModel;
/**
 * Model
 */
class Location extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_locations';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:2,191',
        'slug' => 'required|between:2,191',
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        "address" => ["Cb\Pgmware\Models\LocationAddress"],
        "user" => ["RainLab\User\Models\User"],
        "company" => ["Cb\UserPlus\Models\Company"], // location.company_id = company.id
        "country" => ["RainLab\Location\Models\Country", 'conditions' => 'is_enabled = 1'],
        "timeZone" => ["Cb\Pgmware\Models\Timezone", 'key' => 'timezone_id'],
        "rjgallery" => ['Raviraj\Rjgallery\Models\Gallery']
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
    ];

    public $hasMany = [
        'variants' => ['Cb\Pgmware\Models\Variant']
    ];

    public $attachOne = [
        'location_preview' => 'System\Models\File',
        'location_scheme' => 'System\Models\File',
        'module_file' => 'System\Models\File',
        'location_logo' => 'System\Models\File'
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name', 'description', 'equipment', 'specials', 'name_short', /*'address[name]', 'address[city]'*/];

    private $darkSky = [];

    public function getDarkSky($onlyDay = true)
    {
        $api_key = '1bb793732bf1e830a2eafdb37812305d';


        if (empty($this->darkSky)) {
            $darkSky = json_decode(file_get_contents(
                "https://api.darksky.net/forecast/{$api_key}/{$this->address->gps_lat},{$this->address->gps_lon}?units=si"
            ), true);
            $this->darkSky = $darkSky;
        } else {
            $darkSky = $this->darkSky;
        }


        if (isset($darkSky['daily']['data'])) {
            foreach ($darkSky['daily']['data'] as $key => &$row) {
                $row['day'] = date('l', $row['time']);
                if ($key == 0) {
                    $row['day'] = 'Today';
                }
            }
        }

        if ($onlyDay) {
            if (isset($darkSky['daily']['data'])) {
                return $darkSky['daily']['data'];
            }

            return [];
        }

        return $darkSky;

    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    protected function connectVariants(&$variants, $v, $table)
    {
        $variants->rightJoin($table, function($join) use ($table, $v)
        {
           $join->on($table.'.variant_id', '=', $v.'.id')
           ->whereNull($table.'.deleted_at')
           ->where(\DB::raw('DATE('.$table.'.valid_before_date)'), '>=', date('Y-m-d'))
           ->where($table.'.is_available', 1);
        });
    }

    public function scopeJoinFilterData($query)
    {
        $c = (new CountryModel)->table;
        $con = (new ContinentModel)->table;
        $l = $this->table;
        $v = (new VariantModel)->table;
        $vt = (new VariantTypeModel)->table;
        $addr = (new LocationAddressModel)->table;
        $g = (new GradeModel)->table;
        return $query->leftJoin($v, function($join) use ($l, $v)
        {
            $join->on($l.'.id', '=', $v.'.location_id')
                ->whereNull($l.'.deleted_at');
        })
            ->leftJoin($g, function($join) use ($g, $v)
            {
                $join->on($v.'.grade_id', '=', $g.'.id')
                    ->whereNull($g.'.deleted_at');
            })
            ->leftJoin($c, function($join) use ($c, $l)
            {
                $join->on($l.'.country_id', '=', $c.'.id')
                    ->where($c.'.is_enabled', '1');
            })
            ->leftJoin($con, function($join) use ($con, $c)
            {
                $join->on($c.'.cb_continent_id', '=', $con.'.id')
                    ->where($con.'.is_enabled', '1')
                    ->whereNull($con.'.deleted_at');
            })
            ->leftJoin($vt, function($join) use ($v, $vt)
            {
                $join->on($v.'.variant_type_id', '=', $vt.'.id')
                    ->whereNull($vt.'.deleted_at');
            })
            ->leftJoin($addr, $addr.".id", '=', $l.".address_id");
    }
}
