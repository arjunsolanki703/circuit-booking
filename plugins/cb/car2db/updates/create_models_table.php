<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateModelsTable extends Migration
{
    public function up()
    {
        Schema::create('cb_car2db_models', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_make')->comment('Make');
            $table->string('name');
            $table->unsignedInteger('date_create')->nullable()->default(null);
            $table->unsignedInteger('date_update')->nullable()->default(null);
            $table->integer('id_type');
            $table->timestamps();

            $table->index(["id_make"], 'fk_car_model_car_make');

        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_car2db_models');
    }
}
