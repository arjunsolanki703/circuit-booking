<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareVariants4 extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->renameColumn('grade', 'grade_deprecated');
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_variants', function($table)
        {
            $table->renameColumn('grade_deprecated', 'grade');
        });
    }
}
