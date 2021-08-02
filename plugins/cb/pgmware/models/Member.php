<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class Member extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_members';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
