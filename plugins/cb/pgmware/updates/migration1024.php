<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1024 extends Migration
{
    public function up() {
        Schema::table('cb_pgmware_locations', function ($table) {
            $table->integer('rjgallery_id')->unsigned()->nullable();
        });
    }
    public function down() {
        if (Schema::hasColumn('cb_pgmware_locations', 'rjgallery_id')) {
            Schema::table('cb_pgmware_locations', function ($table) {
                $table->dropColumn('rjgallery_id');
            });
        }
    }
}