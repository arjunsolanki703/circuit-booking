<?php namespace Cb\Car2db\Updates;

use Seeder;
use Cb\Car2db\Models\LastUpdate;

class SeedLastUpdates extends Seeder
{
    public function run()
    {
        LastUpdate::create(['name' => 'generation', 'lastupdate' => 0]);
        LastUpdate::create(['name' => 'make', 'lastupdate' => 0]);
        LastUpdate::create(['name' => 'model', 'lastupdate' => 0]);
        LastUpdate::create(['name' => 'serie', 'lastupdate' => 0]);
        LastUpdate::create(['name' => 'trim', 'lastupdate' => 0]);
    }
}