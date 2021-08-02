<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class Timezone extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_timezones';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:2,191',
        'gmt' => 'required|between:1,191',
    ];
}
