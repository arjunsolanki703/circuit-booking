<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * Model
 */
class Grade extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    use \October\Rain\Database\Traits\Sortable;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_grades';

    public $attachOne = [
        'grade_logo' => 'System\Models\File'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:1,191'
    ];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name'];
    
    public function beforeCreate()
    {
        $this->sort_order = Grade::max('sort_order') + 1;
    }

}
