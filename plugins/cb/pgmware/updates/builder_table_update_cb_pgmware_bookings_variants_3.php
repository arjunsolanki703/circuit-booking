<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareBookingsVariants3 extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->dateTime('track_start_date')->nullable();
            $table->dateTime('track_end_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->dropColumn('track_start_date');
            $table->dropColumn('track_end_date');
        });
    }
}
