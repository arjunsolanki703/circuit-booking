<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterOrderTrackdayTableAddTitle extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_order_trackdays')) {
            Schema::table('cb_trackdaybooking_order_trackdays', function ($table) {
                $table->string('description');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_order_trackdays')) {
            Schema::table('cb_trackdaybooking_order_trackdays', function ($table) {
                $table->dropColumn(['description']);
            });
        }
    }
}
