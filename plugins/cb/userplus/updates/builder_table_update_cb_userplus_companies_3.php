<?php namespace Cb\UserPlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbUserplusCompanies3 extends Migration
{
    public function up()
    {
        Schema::table('cb_userplus_companies', function($table)
        {
            $table->integer('country_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cb_userplus_companies', function($table)
        {
            $table->dropColumn('country_id');
        });
    }
}
