<?php namespace Cb\Demostripe\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCbLnkStripeUsersTable extends Migration
{
    public function up()
    {
        Schema::create('cb_demostripe_cb_lnk_stripe_users', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer("teilnehmerdaten_id");
            $table->string("stripe_client_id");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_demostripe_cb_lnk_stripe_users');
    }
}
