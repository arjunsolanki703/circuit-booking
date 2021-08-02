<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTrimsTable extends Migration
{
    public function up()
    {
        Schema::create('cb_car2db_trims', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_serie');
            $table->integer('id_model');
            $table->string('name');
            $table->integer('start_production_year')->nullable()->default(null);
            $table->integer('end_production_year')->nullable()->default(null);
            $table->unsignedInteger('date_create')->nullable()->default(null);
            $table->unsignedInteger('date_update')->nullable()->default(null);
            $table->integer('id_type');

            $table->timestamps();

            $table->index(["id_serie"], 'fk_car_trim_car_serie');

            $table->index(["id_type"], 'id_car_type');

            $table->index(["id_model"], 'fk_car_trim_car_model');

        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_car2db_trims');
    }
}
