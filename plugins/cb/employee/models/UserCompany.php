<?php namespace Cb\Employee\Models;

use Model;

/**
 * usercompany Model
 */
class UserCompany extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_employee_user_companies';

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
        'company' => 'cb\userplus\models\Company',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
