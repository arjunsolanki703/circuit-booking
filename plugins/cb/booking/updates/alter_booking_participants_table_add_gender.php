<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterBookingParticipantsTableAddGender extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_booking_booking_participants')) {
            Schema::table('cb_booking_booking_participants', function ($table) {
                $table->string('gender', 7)->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_booking_booking_participants')) {
            Schema::table('cb_booking_booking_participants', function ($table) {
                $table->dropColumn(['gender']);
            });
        }
    }
}
