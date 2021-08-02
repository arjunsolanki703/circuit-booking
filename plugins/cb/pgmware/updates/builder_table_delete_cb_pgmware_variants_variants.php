<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteCbPgmwareVariantsVariants extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_lnk_variants_variants', function($table)
        {
            $table->engine = 'InnoDB';
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Fk
            $table->integer('master_variant_id')->unsigned()->nullable()->default(null);
            //$table->foreign('master_variant_id')->references('id')->on('cb_pgmware_variants');
            
            $table->integer('detail_variant_id')->unsigned()->nullable()->default(null);
            //$table->foreign('detail_variant_id')->references('id')->on('cb_pgmware_variants');
            
            // booleans/switches
            $table->boolean('allowed')->default('1');
        });
        
    }
    
    public function down()
    {
        /*
        if (Schema::hasTable('cb_pgmware_lnk_variants_variants')) {
            Schema::table('cb_pgmware_lnk_variants_variants', function($table)
            {
                $table->dropForeign(['master_variant_id']);
                $table->dropForeign(['detail_variant_id']);
                
                //$table->dropColumn('vv_master_variant_id');
                //$table->dropColumn('vv_detail_variant_id');
            });
        }
        */
        
        Schema::dropIfExists('cb_pgmware_lnk_variants_variants');

    }
}