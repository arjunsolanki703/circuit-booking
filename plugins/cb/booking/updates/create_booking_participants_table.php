<?php namespace Cb\Booking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBookingParticipantsTable extends Migration
{
    public function up()
    {
        Schema::create('cb_booking_booking_participants', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer("user_id", false, true);
            $table->string("name");
            $table->string("surname");
            $table->string("email");
            $table->string("zip");
            $table->string("address");
            $table->integer("country_id");
            $table->string("city");
            $table->string("phone");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_booking_booking_participants');
    }
}
