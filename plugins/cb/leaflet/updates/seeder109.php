<?php namespace Cb\Leaflet\Updates;

use Seeder;
use Cb\Leaflet\Models\Maps;

class Seeder109 extends Seeder
{
    public function run()
    {
        Maps::create([
            'name' => 'world',
            'mapboxId' => 'mapbox://styles/elena-jilyakova/cjs06ue803eaf1fpcn90iysh1',
            'mapboxAccessToken' => 'pk.eyJ1IjoiZWxlbmEtamlseWFrb3ZhIiwiYSI6ImNqczA1b2Z5MzFnYXAzeW9kbzlmZXBlM28ifQ.B6SxBdUKQfmWp3pHZMI2eQ'
        ]);
    }
}