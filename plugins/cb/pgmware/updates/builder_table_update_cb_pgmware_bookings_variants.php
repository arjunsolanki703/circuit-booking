<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbPgmwareBookingsVariants extends Migration
{
    public function up()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->renameColumn('meeteng_rooms', 'meeting_rooms');
        });
    }
    
    public function down()
    {
        Schema::table('cb_pgmware_bookings_variants', function($table)
        {
            $table->renameColumn('meeting_rooms', 'meeteng_rooms');
        });
    }
}