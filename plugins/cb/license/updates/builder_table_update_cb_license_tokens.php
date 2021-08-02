<?php namespace Cb\License\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCbLicenseTokens extends Migration
{
    public function up()
    {
        Schema::table('cb_license_tokens', function($table)
        {
            $table->string('value', 1000)->change();
        });
    }
    
    public function down()
    {
        Schema::table('cb_license_tokens', function($table)
        {
            $table->string('value', 500)->change();
        });
    }
}