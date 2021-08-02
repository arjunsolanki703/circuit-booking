<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareVariants extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_variants', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Fk
            $table->integer('location_id')->unsigned()->nullable()->default(null);   
            //$table->foreign('location_id')->references('id')->on('cb_pgmware_locations');
            
            $table->integer('variant_type_id'); // Added in variant_type version
             // $table->integer('v_variant_type_id'); // Added in variant_type version
            
            //properties
            $table->string('name');
            $table->string('cost_type', 45)->nullable()->default(null);
            $table->string('cost_center', 45)->nullable()->default(null);
            $table->string('color', 64)->nullable()->default(null);
            //$table->string('v_type')->nullable()->default(null);
    
            $table->longText('description');
            $table->integer('sort_order')->default(1)->default(null); // For sorting purposes in userdisplays
            $table->integer('length')->nullable()->default(null); // For sorting purposes in userdisplays
            
            // uploads, as it is not clear, how we can handle uploads, these attrbutes are commended out
            // $table->integer('v_layout')->nullable()->default(null);  // layout picture of the variant       
            
            // booleans/switches
            $table->boolean('bookable')->default('1');            
            
            // saved for later use in additional plugins
            // $table->integer('_ref_v_id')->nullable()->default(null);
            // $table->string('_lang_v_id', 5)->nullable()->default(null);
            // $table->string('v_geojson')->nullable()->default(null);
            // $table->integer('v_geojson_file')->nullable()->default(null);
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_pgmware_variants');
    }
}