<?php namespace Cb\License\Models;

use Model;
use ValidationException;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token as JWTToken;

/**
 * Model
 */
class Token extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_license_tokens';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'value' => 'required'
    ];

    public function decode()
    {
        //$payload = JWTFactory::sub(123)->plugins(['pgmware', 'newsplus', 'leaflet'])->make();
        //$token = JWTAuth::encode($payload);

        /*var_dump($token);
        echo'<pre>';
        var_dump(JWTAuth::decode($token));
        die();*/
      
        return implode(', ', JWTAuth::decode(new JWTToken($this->value))['plugins']);
    }

    public function decodeFull()
    {
        return JWTAuth::decode(new JWTToken($this->value));
    }

    public function beforeCreate()
    {
        try {
            $this->decode();
        } catch (Exception $ex) {
            throw new ValidationException($errors);
        }
    }

    public function beforeSave()
    {
        try {
            $this->decode();
        } catch (Exception $ex) {
            throw new ValidationException($errors);
        }
    }
}
