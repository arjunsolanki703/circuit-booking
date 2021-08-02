<?php namespace Cb\UserPlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbUserplusCompanies extends Migration
{
    public function up()
    {
        Schema::create('cb_userplus_companies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100);
            $table->string('zip', 20);
            $table->string('phone', 20);
            $table->string('fax', 20);
            $table->string('address', 255);
            $table->string('url', 255);
            $table->string('vat_number', 20);
            $table->integer('city_id');
            $table->integer('user_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_userplus_companies');
    }
}
