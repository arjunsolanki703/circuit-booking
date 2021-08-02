<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use RainLab\Location\Models\Country as CountryModel;

class Migration1029 extends Migration
{
    public function up()
    {
        Schema::table('rainlab_location_countries', function($table)
        {
            $table->string('cb_slug', 100)->nullable();
        });
        $list = CountryModel::get();
        foreach ($list as $r) {
            $r->cb_slug = str_slug($r->name, '-');
            $r->save();
        }
    }

    public function down()
    {
        Schema::table('rainlab_location_countries', function($table)
        {
            $table->dropColumn('cb_slug');
        });
    }
}