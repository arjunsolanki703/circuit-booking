<?php namespace Cb\Booking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('cb_booking_bookings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('number_prefix', 20);
            $table->string('number')->nullable()->default(null);
            $table->string('description');
            //$table->string('barcode')->nullable()->default(null);
            //$table->tinyInteger('shopping_card')->nullable()->default(null);
            //$table->tinyInteger('sent_to_customer')->nullable()->default(null);
            //$table->dateTime('insdat')->nullable()->default(null);
            //$table->dateTime('upddat')->nullable()->default(null);
            //$table->integer('insusr')->nullable()->default(null);
            //$table->integer('updusr')->nullable()->default(null);
            //$table->integer('comany_id');
            $table->integer('booking_status_id');
            //$table->integer('responsible');
            //$table->integer('invoice_address');
            //$table->tinyInteger('changed')->default('0');
            //$table->integer('quotation')->nullable()->default(null);
            //$table->integer('protocol')->nullable()->default(null);
            //$table->tinyInteger('ilming')->nullable()->default(null);
            //$table->integer('bo_file')->nullable()->default(null);
            //$table->longText('further_details')->nullable()->default(null);
            //$table->tinyInteger('collective_invoice')->default('0');
            //$table->float('total_amount_net')->nullable()->default(null);
            //$table->float('total_amount_brutto')->nullable()->default(null);
            //$table->dateTime('close_date')->nullable()->default(null);
            $table->integer('booking_type_id');
            //$table->integer('bo_pt_id')->nullable()->default(null);
            //$table->integer('participantlist')->nullable()->default(null);
            //$table->integer('location_id');
            //$table->longText('bo_note_b2b')->nullable()->default(null);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_booking_bookings');
    }
}
