<?php namespace Cb\Pgmware\Updates;

use Seeder;
use  Cb\Pgmware\Models\Continent;

class Seeder1023 extends Seeder
{
    public function run()
    {
        $json = file_get_contents('https://gist.githubusercontent.com/hrbrmstr/91ea5cc9474286c72838/raw/59421ff9b268ff0929b051ddafafbeb94a4c1910/continents.json');
        
        $json = json_decode($json);
        foreach ($json->features as $r) {
            $res = Continent::create(['geojson' => json_encode($r), 'name' => $r->properties->CONTINENT, 'code' =>  substr($r->properties->CONTINENT, 0, 3)]);
        }
    }
}