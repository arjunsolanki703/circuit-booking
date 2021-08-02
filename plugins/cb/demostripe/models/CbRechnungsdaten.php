<?php namespace Cb\Demostripe\Models;

use Model;

/**
 * cb_rechnungsdaten Model
 */
class CbRechnungsdaten extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_demostripe_cb_rechnungsdatens';

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
