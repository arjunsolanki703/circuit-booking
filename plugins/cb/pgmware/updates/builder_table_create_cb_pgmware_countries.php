<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareCountries extends Migration
{
    public function up()
    {
        /*
        Schema::create('cb_pgmware_countries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('country_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Fk
            // $table->integer('continent_id')->nullable()->default(null); // Added in continents-version
            
            //properties
            $table->string('c_name');
            $table->string('c_longname');
            
            $table->string('c_iso3', 3);
            $table->string('c_importpath', 128)->nullable()->default(null);
            
            $table->char('c_iso', 2);
            
            $table->tinyInteger('c_num');
            
            // booleans/switches
            $table->boolean('c_active')->default('0');
                 
        });
        
        if (Schema::hasTable('cb_pgmware_locations')) {
            Schema::table('cb_pgmware_locations', function($table)
            {
                if (!Schema::hasColumn('cb_pgmware_locations', 'l_country_id')) {
                    $table->integer('l_country_id')->unsigned()->nullable()->default(null);
                }
                $table->foreign('l_country_id')->references('country_id')->on('cb_pgmware_countries');
            });
        }
        
        if (Schema::hasTable('cb_pgmware_companies')) {
            Schema::table('cb_pgmware_companies', function($table)
            {
                if (!Schema::hasColumn('cb_pgmware_companies', 'co_country_id')) {
                    $table->integer('co_country_id')->unsigned()->nullable()->default(null);
                }
                $table->foreign('co_country_id')->references('country_id')->on('cb_pgmware_countries');
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
                $table->dropForeign(['l_country_id']);
                // $table->dropColumn('l_country_id');
            });
        }
        
        if (Schema::hasTable('cb_pgmware_companies')) {
            Schema::table('cb_pgmware_companies', function($table)
            {
                $table->dropForeign(['co_country_id']);
                // $table->dropColumn('co_country_id');
            });
        }
        
        Schema::dropIfExists('cb_pgmware_countries');
        */
    }
}