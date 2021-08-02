<?php namespace Cb\Car2db\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Cb\Car2db\Models\Make As MakeModel;

/**
 * model Model
 */
class Model extends BaseModel
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_car2db_models';

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
        'serie' => 'cb\car2db\models\Serie',
    ];
    public $belongsTo = [
        'make' => 'cb\car2db\models\Make',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getMake() {
        return MakeModel::where('id', $this->id_make)->first();
    }
}
