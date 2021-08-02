<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterBookingTypesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_booking_booking_types')) {
            Schema::table('cb_booking_booking_types', function ($table) {
                $table->string('pluginname');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_booking_booking_types')) {
            Schema::table('cb_booking_booking_types', function ($table) {
                $table->dropColumn(['pluginname']);
            });
        }
    }
}
