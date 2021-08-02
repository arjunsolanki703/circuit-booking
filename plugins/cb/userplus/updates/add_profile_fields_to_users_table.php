<?php namespace Cb\UserPlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('cb_last_name', 100)->nullable();
            $table->string('cb_gender', 7)->nullable();
            $table->string('cb_function', 100)->nullable();
            $table->string('cb_telephone', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn([
                'cb_last_name', 'cb_gender', 'cb_function', 'cb_telephone'
            ]);
        });
    }
}