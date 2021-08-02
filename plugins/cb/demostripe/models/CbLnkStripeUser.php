<?php namespace Cb\Demostripe\Models;

use Model;

/**
 * cb_lnk_stripe_user Model
 */
class CbLnkStripeUser extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_demostripe_cb_lnk_stripe_users';

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
