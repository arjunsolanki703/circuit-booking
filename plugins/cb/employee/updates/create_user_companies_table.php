<?php namespace Cb\Employee\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUserCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('cb_employee_user_companies', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_employee_user_companies');
    }
}
