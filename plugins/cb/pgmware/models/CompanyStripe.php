<?php namespace Cb\Pgmware\Models;

use Model;
use \October\Rain\Database\Traits\SoftDelete;

/**
 * CompanyStripe Model
 */
class CompanyStripe extends Model
{

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_company_stripes';

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
    public $hasOne = ["company" => ["Cb\Userplus\Models\Company"]];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
