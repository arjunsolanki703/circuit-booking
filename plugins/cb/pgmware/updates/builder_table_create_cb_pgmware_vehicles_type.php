<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareVehiclesType extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_vehicle_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->string('name');
            $table->string('icon', 64)->nullable()->default(null);
            
            $table->tinyInteger('order')->default('1');
        });
        
        /*
        if (Schema::hasTable('cb_pgmware_vehicles')) {
            Schema::table('cb_pgmware_vehicles', function($table)
            {
                if (!Schema::hasColumn('cb_pgmware_vehicles', 'vehicle_type_id')) {
                    $table->integer('vehicle_type_id')->unsigned()->nullable()->default(null);
                }
                $table->foreign('vehicle_type_id')->references('id')->on('cb_pgmware_vehicle_types');
 
            });
        }
        */
        
        
        Schema::create('cb_pgmware_lnk_variant_vehicle_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Fk
            $table->integer('variant_id')->unsigned()->nullable()->default(null);
            //$table->foreign('variant_id')->references('id')->on('cb_pgmware_variants');
            
            $table->integer('vehicle_type_id')->unsigned()->nullable()->default(null);
            //$table->foreign('vehicle_type_id')->references('id')->on('cb_pgmware_vehicle_types');
                        
        });
 
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_pgmware_lnk_variant_vehicle_types');
        Schema::dropIfExists('cb_pgmware_vehicle_types');
        /*
        return;
        
        if (Schema::hasTable('cb_pgmware_lnk_variant_vehicle_types')) {
            Schema::table('cb_pgmware_lnk_variant_vehicle_types', function($table)
            {
                if (Schema::hasColumn('cb_pgmware_lnk_variant_vehicle_types', 'variant_id')) {
                    $table->dropForeign(['variant_id']);
                    // $table->dropColumn('vvt_variant_id');
                }
                
                if (Schema::hasColumn('cb_pgmware_lnk_variant_vehicle_types', 'vehicle_type_id')) {
                     $table->dropForeign(['vehicle_type_id']);
                    // $table->dropColumn('vvt_vehicle_type_id');
                }
            });
        }
        */
        
        
        /*
         if (Schema::hasTable('cb_pgmware_vehicles')) {
            Schema::table('cb_pgmware_vehicles', function($table)
            {
                if (Schema::hasColumn('cb_pgmware_vehicles', 'vehicle_type_id')) {
                    $table->dropForeign(['vehicle_type_id']);
                    // $table->dropColumn('v_vehicle_type_id');
                }
            });
        }
        */
        
    }
}