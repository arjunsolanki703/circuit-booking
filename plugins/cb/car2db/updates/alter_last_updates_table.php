<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterLastUpdatesTable extends Migration
{
    public function up()
    {
        Schema::table('cb_car2db_last_updates', function ($table) {
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::table('cb_car2db_last_updates', function ($table) {
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
        });
    }
}
