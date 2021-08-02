<?php namespace Cb\Booking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBookingStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_booking_booking_statuses', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 64);
            // $table->string('color', 64)->nullable();;
            $table->integer('order')->nullable();;
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_booking_booking_statuses');
    }
}
