<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddContinentFieldToCountriesTable extends Migration
{
    public function up()
    {

        Schema::table('rainlab_location_countries', function($table)
        {
            $table->integer('cb_continent_id')->nullable();
            $table->text('cb_description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('rainlab_location_countries', function($table)
        {
            $table->dropColumn([
                'cb_continent_id',
                'cb_description'
            ]);
        });
    }
}