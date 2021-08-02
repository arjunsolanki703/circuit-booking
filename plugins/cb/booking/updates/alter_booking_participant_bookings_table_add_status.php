<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterBookingParticipantBookingsTableAddStatus extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_booking_booking_participant_bookings')) {
            Schema::table('cb_booking_booking_participant_bookings', function ($table) {
                $table->integer('booking_status_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_booking_booking_participant_bookings')) {
            Schema::table('cb_booking_booking_participant_bookings', function ($table) {
                $table->dropColumn(['booking_status_id']);
            });
        }
    }
}
