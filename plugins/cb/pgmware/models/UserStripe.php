<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * @deprecated Do NOT use UserStripe it is not actual link between Users and Stripeaccount. Use CompanyStripe, please.
 * user_stripe Model
 */
class UserStripe extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_user_stripes';

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
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
