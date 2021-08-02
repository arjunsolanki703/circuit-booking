<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareContinents extends Migration
{
    public function up()
    {  
        Schema::create('cb_pgmware_continents', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->string('name');
            $table->string('code', 3);
            $table->boolean('is_enabled')->default('1');
            $table->longText('description')->nullable()->default(null);
            
        });
        
        /*
        if (Schema::hasTable('cb_pgmware_countries')) {
            Schema::table('cb_pgmware_countries', function($table)
            {
                if (!Schema::hasColumn('cb_pgmware_countries', 'continent_id')) {
                    $table->integer('continent_id')->unsigned()->nullable()->default(null);
                }
                $table->foreign('continent_id')->references('id')->on('cb_pgmware_continents');
            });
        }
        */
    }
    
    public function down()
    {
        /*
        if (Schema::hasTable('cb_pgmware_countries')) {
            Schema::table('cb_pgmware_countries', function($table)
            {
                $table->dropForeign(['continent_id']);
                //$table->dropColumn('c_continent_id');
            });
        }
        */
        
        Schema::dropIfExists('cb_pgmware_continents');
        
    }
}