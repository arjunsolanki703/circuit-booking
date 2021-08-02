<?php namespace Cb\Car2db\Models;

use Model AS BaseModel;

/**
 * make Model
 */
class Make extends BaseModel
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_car2db_makes';

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
        'model' => 'cb\car2db\models\Model',
    ];
    public $belongsTo = [
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
