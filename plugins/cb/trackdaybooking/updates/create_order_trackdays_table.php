<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrderTrackdaysTable extends Migration
{
    public function up()
    {
        Schema::create('cb_trackdaybooking_order_trackdays', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('price', 10, 0);
            $table->integer('currency_id');
            $table->double('vat_value', 10, 6);
            $table->integer('trackday_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_trackdaybooking_order_trackdays');
    }
}
