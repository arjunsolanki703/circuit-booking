<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareLocations extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_locations', function($table)
        {
            $table->boolean('featured')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_locations', function($table)
        {
            $table->dropColumn('featured');
        });
    }
}