<?php namespace Cb\UserPlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbUserplusCompanies2 extends Migration
{
    public function up()
    {
        Schema::table('cb_userplus_companies', function($table)
        {
            $table->string('city', 100)->nullable();
            $table->dropColumn('city_id');
        });
    }
    
    public function down()
    {
        Schema::table('cb_userplus_companies', function($table)
        {
            $table->dropColumn('city');
            $table->integer('city_id')->nullable();
        });
    }
}
