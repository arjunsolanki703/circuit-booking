<?php namespace Cb\Car2db\Models;

use Model;

/**
 * user_vehicle Model
 */
class UserVehicle extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_car2db_user_vehicles';

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
    public $hasMany = [];
    public $belongsTo = [
        'user' => 'rainlab\user\models\User',
        'trim' => 'cb\car2db\models\Trim',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
