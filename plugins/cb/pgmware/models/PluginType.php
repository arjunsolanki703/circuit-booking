<?php namespace Cb\Pgmware\Models;

use Model;

/**
 * PluginType Model
 */
class PluginType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_plugin_types';

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
