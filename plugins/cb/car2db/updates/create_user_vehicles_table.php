<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUserVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_car2db_user_vehicles', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('trim_id');
            $table->string('licenseplate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_car2db_user_vehicles');
    }
}
