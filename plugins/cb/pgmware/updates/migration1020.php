<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1020 extends Migration
{
    public function up()
    {
        Schema::table('rainlab_location_countries', function($table)
        {
            $table->longText('cb_geojson')->nullable();
        });
    }

    public function down()
    {
        Schema::table('rainlab_location_countries', function($table)
        {
            $table->dropColumn([
                'cb_geojson'
            ]);
        });
    }
}