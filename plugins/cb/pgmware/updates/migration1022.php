<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1022 extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_continents', function($table)
        {
            $table->longText('geojson')->nullable();
        });
    }

    public function down()
    {
        Schema::table('cb_pgmware_continents', function($table)
        {
            $table->dropColumn([
                'geojson'
            ]);
        });
    }
}