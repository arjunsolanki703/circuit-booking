<?php namespace Cb\UserPlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbUserplusCompanies extends Migration
{
    public function up()
    {
        return;
        Schema::table('cb_userplus_companies', function($table)
        {
            $table->integer('user_id')->nullable();
        });
    }
    
    public function down()
    {
        return;
        Schema::table('cb_userplus_companies', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
