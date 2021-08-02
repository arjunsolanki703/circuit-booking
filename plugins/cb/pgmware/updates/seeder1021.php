<?php namespace Cb\Pgmware\Updates;

use Seeder;
use  RainLab\Location\Models\Country;

class Seeder1021 extends Seeder
{
    public function run()
    {
        $json = file_get_contents('https://d2ad6b4ur7yvpq.cloudfront.net/naturalearth-3.3.0/ne_50m_admin_0_countries.geojson');
        
        $json = json_decode($json);
        foreach ($json->features as $r) {
            $res = Country::where('code', $r->properties->iso_a2)->update(['cb_geojson' => json_encode($r)]);
        }

    }
}