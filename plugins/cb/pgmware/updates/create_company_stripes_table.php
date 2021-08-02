<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCompanyStripesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_company_stripes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('stripe_user_id');
            $table->integer('company_id');
            $table->integer('added_by_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_pgmware_company_stripes');
    }
}
