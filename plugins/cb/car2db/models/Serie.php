<?php namespace Cb\Car2db\Models;

use Model AS BaseModel;
use Cb\Car2db\Models\Model As CarModel;
use Cb\Car2db\Models\Generation As GenerationModel;


/**
 * serie Model
 */
class Serie extends BaseModel
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_car2db_series';

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
        'trim' => 'cb\car2db\models\Trim',
    ];
    public $belongsTo = [
        'model' => 'cb\car2db\models\Model',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getModel() {
        return CarModel::where('id', $this->id_model)->first();
    }

    public function getGeneration() {
        return GenerationModel::where('id', $this->id_generation)->first();
    }
}
