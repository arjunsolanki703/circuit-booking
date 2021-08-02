<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareBookingsVariants4 extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->integer('consecutive_days')->nullable();
            $table->integer('tear_down_days')->nullable();
            $table->integer('setup_days')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->dropColumn('consecutive_days');
            $table->dropColumn('tear_down_days');
            $table->dropColumn('setup_days');
        });
    }
}
