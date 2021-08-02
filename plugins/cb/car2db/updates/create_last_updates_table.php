<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLastUpdatesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_car2db_last_updates', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('lastupdate');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_car2db_last_updates');
    }
}
