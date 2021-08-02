<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareCircuitSharing extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_circuit_sharing', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 191);
            $table->boolean('is_available')->default(0);
            $table->boolean('is_booked')->default(0);
            $table->integer('vehicles_count');
            $table->integer('variant_id');
            $table->integer('currency_id');
            $table->text('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('booking_type_id');
            $table->double('price', 10, 0);
            $table->string('circuit_sharing_type', 191);
            $table->dateTime('valid_before_date');
            $table->boolean('is_with_vat')->default(0);
            $table->integer('vehicle_type_id');
            $table->integer('user_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_pgmware_circuit_sharing');
    }
}