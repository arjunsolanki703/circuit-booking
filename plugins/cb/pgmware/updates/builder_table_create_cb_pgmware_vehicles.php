<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareVehicles extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_vehicles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Fk
            $table->integer('vehicle_type_id'); // Added in vehicle_type-Version
            $table->integer('company_id')->unsigned()->nullable()->default(null);   // october_user_id
            //$table->foreign('company_id')->references('id')->on('cb_pgmware_companies');
            
            // properties
            $table->string('description');
            $table->string('license_plate', 64);
            $table->string('notes')->nullable()->default(null);
            $table->string('drivetype')->nullable()->default(null);
            
            $table->integer('power');
            $table->integer('max_speed');
            $table->integer('noise');
            
            // booleans
            $table->boolean('checkedin')->default('0');
            $table->boolean('mule')->default('0');
            
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_pgmware_vehicles');
    }
}