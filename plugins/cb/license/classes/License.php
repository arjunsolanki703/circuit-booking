<?php namespace Cb\License\Classes;

use Lang;
use Cb\License\Models\Token;

class License {

    public function pluginIsValid($plugin)
    {
        $list = Token::get();
        foreach ($list as $r) {
            $plugins = $r->decodeFull()['plugins'];
            if (array_search($plugin, $plugins)) {
                return true;
            }
        }
        return false;
    }
}
// use Cb\License\Classes\License;
// $v = new License();
// var_dump($v->pluginIsValid('leaflet'));die();