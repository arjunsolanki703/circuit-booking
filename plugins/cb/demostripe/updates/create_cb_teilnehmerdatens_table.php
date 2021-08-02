<?php namespace Cb\Demostripe\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCbTeilnehmerdatensTable extends Migration
{
    public function up()
    {
        Schema::create('cb_demostripe_cb_teilnehmerdatens', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('street');
            $table->string('zip');
            $table->string('city');
            $table->string('country');
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('email');
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_demostripe_cb_teilnehmerdatens');
    }
}
