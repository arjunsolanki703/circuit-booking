<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class VariantType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_variant_types';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'description' => 'required|between:1,191',
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['description'];
}
