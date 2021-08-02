<?php namespace Cb\Leaflet\Models;

use Model;

/**
 * Model
 */
class Maps extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required'
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'timfoerster_leaflet_maps';

    public $hasMany = [
        'objects' => ['Cb\Leaflet\Models\Objects'],
        'objects_count' => ['Cb\Leaflet\Models\Objects', 'count' => true],
    ];

    public function objects() {
        return $this->hasMany('Cb\Leaflet\Models\Objects');
    }

}
