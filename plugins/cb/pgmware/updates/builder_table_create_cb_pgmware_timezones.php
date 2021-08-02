<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareTimezones extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_timezones', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // properties
            $table->string('GMT', 5);
            $table->string('name', 120);
        });
        
        /*
        if (Schema::hasTable('cb_pgmware_locations')) {
            Schema::table('cb_pgmware_locations', function($table)
            {
                if (!Schema::hasColumn('cb_pgmware_locations', 'l_timezone_id')) {
                    $table->integer('timezone_id')->unsigned()->nullable()->default(null);
                }
                $table->foreign('timezone_id')->references('id')->on('cb_pgmware_timezones');

            });
        }
        */
    }
    
    public function down()
    {
        /*
        if (Schema::hasTable('cb_pgmware_locations')) {
            Schema::table('cb_pgmware_locations', function($table)
            {
                $table->dropForeign(['timezone_id']);
                // $table->dropColumn('l_timezone_id');
            });
        }
        */
        
        Schema::dropIfExists('cb_pgmware_timezones');
    }
}