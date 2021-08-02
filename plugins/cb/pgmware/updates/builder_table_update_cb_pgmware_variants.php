<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareVariants extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->string('grade', 10)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->dropColumn('grade');
        });
    }
}