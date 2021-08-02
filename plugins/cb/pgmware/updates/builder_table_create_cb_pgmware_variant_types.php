<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareVariantTypes extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_variant_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
             //properties
            $table->string('description');
        });
        
        /*
         if (Schema::hasTable('cb_pgmware_variants')) {
            Schema::table('cb_pgmware_variants', function($table)
            {
                if (!Schema::hasColumn('cb_pgmware_variants', 'variant_type_id')) {
                    $table->integer('variant_type_id')->unsigned()->nullable()->default(null);
                }
                $table->foreign('variant_type_id')->references('id')->on('cb_pgmware_variant_types');
            });
        }
        */
    }
    
    public function down()
    {
        /*
        if (Schema::hasTable('cb_pgmware_variants')) {
            Schema::table('cb_pgmware_variants', function($table)
            {
                $table->dropForeign(['variant_type_id']);
                // $table->dropColumn('v_variant_type_id');
            });
        }
        */
        
        Schema::dropIfExists('cb_pgmware_variant_types');
    }
}