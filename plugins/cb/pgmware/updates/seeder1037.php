<?php namespace Cb\Pgmware\Updates;

use Seeder;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cb\Pgmware\Models\Grade as GradeModel;

class Seeder1037 extends Seeder
{
    public function run()
    {
        GradeModel::create(['name' => '1']);
        GradeModel::create(['name' => '2']);
        GradeModel::create(['name' => '3']);
        GradeModel::create(['name' => '4']);
        GradeModel::create(['name' => '5']);
        
        $grades = GradeModel::get()->keyBy('name')->toArray();
        $list = VariantModel::get();
        
        foreach ($list as $r) {
            if (isset($grades[$r->grade])) {
                $r->grade_id = $grades[$r->grade]['id'];
                $r->save();
            }
        }
    }
}