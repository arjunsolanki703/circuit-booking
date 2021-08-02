<?php namespace Cb\Car2db\Models;

use Model;

/**
 * generation Model
 */
class Generation extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_car2db_generations';

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
