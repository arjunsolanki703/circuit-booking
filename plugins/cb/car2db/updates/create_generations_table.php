<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateGenerationsTable extends Migration
{
    public function up()
    {
        Schema::create('cb_car2db_generations', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_model');
            $table->string('name');
            $table->string('year_begin')->nullable()->default(null);
            $table->string('year_end')->nullable()->default(null);
            $table->unsignedInteger('date_create');
            $table->unsignedInteger('date_update')->nullable()->default(null);
            $table->integer('id_type')->default('0');

            $table->timestamps();

            $table->index(["id_type"], 'id_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_car2db_generations');
    }
}
