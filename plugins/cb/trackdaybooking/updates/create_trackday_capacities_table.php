<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTrackdayCapacitiesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_trackdaybooking_trackday_capacities', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('trackday_id');
            $table->integer('amount');
            $table->dateTime('bookable_from');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_trackdaybooking_trackday_capacities');
    }
}
