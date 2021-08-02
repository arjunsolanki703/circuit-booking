<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareVariants2 extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->dateTime('fia_grade_valid_before_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->dropColumn('fia_grade_valid_before_date');
        });
    }
}
