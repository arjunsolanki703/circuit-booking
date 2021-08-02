<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTrackdaysTable extends Migration
{
    public function up()
    {
        Schema::create('cb_trackdaybooking_trackdays', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('companie_id');
            $table->integer('variant_id');
            $table->integer('vehicle_type_id');
            $table->string('title', 191);
            $table->text('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('price', 10, 0);
            $table->integer('currency_id');
            $table->double('vat_value', 10, 6);
            $table->boolean('bookable')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_trackdaybooking_trackdays');
    }
}
