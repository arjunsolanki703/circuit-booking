<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUserStripesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_user_stripes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string("stripe_user_id");
            $table->integer("user_id");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_pgmware_user_stripes');
    }
}
