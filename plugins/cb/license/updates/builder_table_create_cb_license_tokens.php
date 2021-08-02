<?php namespace Cb\License\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbLicenseTokens extends Migration
{
    public function up()
    {
        Schema::create('cb_license_tokens', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('value', 500);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_license_tokens');
    }
}
