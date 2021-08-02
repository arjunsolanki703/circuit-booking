<?php namespace Cb\UserPlus\Updates;

use Seeder;
use Indikator\News\Models\Categories;

class Seeder107 extends Seeder
{
    public function run()
    {
       Categories::create(['name' => 'News', 'slug' => 'news', 'status' => 1, 'hidden' => 1]);
       Categories::create(['name' => 'Jobs', 'slug' => 'jobs', 'status' => 1, 'hidden' => 1]);
    }
}