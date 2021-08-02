<?php namespace Cb\Demostripe\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCbRechnungsdatensTable extends Migration
{
    public function up()
    {
        Schema::create('cb_demostripe_cb_rechnungsdatens', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('company');
            $table->string('street');
            $table->string('zip');
            $table->string('city');
            $table->string('country');
            $table->string('email');
            $table->string('phone');
            $table->integer('teilnehmerdaten_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_demostripe_cb_rechnungsdatens');
    }
}
