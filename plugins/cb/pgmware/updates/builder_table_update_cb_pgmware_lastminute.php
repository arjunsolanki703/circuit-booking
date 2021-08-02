<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareLastminute extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_lastminute', function($table)
        {
            $table->renameColumn('id_available', 'is_available');
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_lastminute', function($table)
        {
            $table->renameColumn('is_available', 'id_available');
        });
    }
}