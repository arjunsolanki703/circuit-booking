<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareOrdersVariants extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_bookings_variants', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('variant_id');
            $table->integer('vehicle_type_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('vehicles_count');
            $table->integer('garage')->nullable();
            $table->integer('meeteng_rooms')->nullable();
            $table->integer('booking_type_id');
            $table->boolean('time_keeping')->default(0);
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_pgmware_bookings_variants');
    }
}