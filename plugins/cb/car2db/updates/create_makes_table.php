<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMakesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_car2db_makes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('date_create')->nullable()->default(null);
            $table->unsignedInteger('date_update')->nullable()->default(null);
            $table->integer('id_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_car2db_makes');
    }
}
