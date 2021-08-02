<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareAdress extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_location_address', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->string('name');
            $table->string('street');
            $table->string('additional');
            $table->string('zip', 20);
            $table->string('city');
            $table->string('phone', 20)->nullable()->default(null);
            $table->string('fax', 20)->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('web')->nullable()->default(null);
            
            $table->double('gps_lat');
            $table->double('gps_lon');
        });
    }
    
    public function down()
    {
       Schema::dropIfExists('cb_pgmware_location_address');
    }
}