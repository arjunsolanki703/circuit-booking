<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareCircuitSharing extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_circuit_sharing', function($table)
        {
            $table->boolean('is_available')->default(1)->change();
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_circuit_sharing', function($table)
        {
            $table->boolean('is_available')->default(0)->change();
        });
    }
}
