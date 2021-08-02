<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class Variant extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    use \October\Rain\Database\Traits\Sortable;

    //use \October\Rain\Database\Traits\NestedTree;

    protected $dates = ['deleted_at'];

    public $gradeList = [
        '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_variants';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'description' => 'required',
        'name' => 'required',
        'cost_type' => 'max:45',
        'cost_center' => 'max:45',
        'variant_type_id' => 'required',
        'location' => "required"
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'sort_order',
        'name',
        'description',
        'cost_type',
        'cost_center',
    ];

    public $belongsTo = [
        'variantType' => ['Cb\Pgmware\Models\VariantType', 'key' => 'variant_type_id'],
        'location' => ['Cb\Pgmware\Models\Location'],
        'grade' => ['Cb\Pgmware\Models\Grade']
    ];

    public $belongsToMany = [
        'vehicleTypes' => ['Cb\Pgmware\Models\VehicleType', 'table' => 'cb_pgmware_lnk_variant_vehicle_types']
    ];
    public $attachOne = [
        'variant_scheme' => 'System\Models\File',
    ];

    public $hasMany = [
        'sharing' => ['Cb\Pgmware\Models\CircuitSharing']
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name', 'description'];

    public function beforeCreate()
    {
        $this->sort_order = Variant::max('sort_order') + 1;
    }

    public function scopeBookable($query)
    {
        return $query->where('bookable', true);
    }

    public function listGrade()
    {
        return $this->gradeList;
    }



}
