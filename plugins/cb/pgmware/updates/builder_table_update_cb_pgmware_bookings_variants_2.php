<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareBookingsVariants2 extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->integer('user_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
