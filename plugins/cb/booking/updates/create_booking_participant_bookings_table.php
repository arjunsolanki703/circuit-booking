<?php namespace Cb\Booking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBookingParticipantBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('cb_booking_booking_participant_bookings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('booking_id');
            $table->integer('booking_participant_id');
            $table->integer('participant_type_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_booking_booking_participant_bookings');
    }
}
