<?php namespace Cb\Car2db\Models;

use Model AS BaseModel;
use Cb\Car2db\Models\Serie As SerieModel;

/**
 * trim Model
 */
class Trim extends BaseModel
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_car2db_trims';

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
        'userVehicle' => 'cb\car2db\models\UserVehicle',
    ];
    public $belongsTo = [
        'serie' => 'cb\car2db\models\Serie',
        'model' => 'cb\car2db\models\Model',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    public function getSerie() {
        return SerieModel::where('id', $this->id_serie)->first();
    }
}
