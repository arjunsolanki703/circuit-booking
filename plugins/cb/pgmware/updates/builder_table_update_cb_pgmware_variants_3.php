<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareVariants3 extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->integer('grade_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->dropColumn('grade_id');
        });
    }
}
