<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSeriesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_car2db_series', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_model');
            $table->integer('id_generation')->nullable()->default(null);
            $table->string('name');
            $table->unsignedInteger('date_create')->nullable()->default(null);
            $table->unsignedInteger('date_update')->nullable()->default(null);
            $table->integer('id_type');

            $table->timestamps();

            $table->index(["id_model"], 'fk_car_serie_car_model');

            $table->index(["id_generation"], 'fk_car_serie_car_generation');

            $table->index(["id_type"], 'id_car_type');

        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_car2db_series');
    }
}
