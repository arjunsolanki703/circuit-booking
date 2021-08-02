<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterOrderTrackdayTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_order_trackdays')) {
            Schema::table('cb_trackdaybooking_order_trackdays', function ($table) {
                $table->dateTime('start_date');
                $table->dateTime('end_date');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_order_trackdays')) {
            Schema::table('cb_trackdaybooking_order_trackdays', function ($table) {
                $table->dropColumn(['start_date']);
                $table->dropColumn(['end_date']);
            });
        }
    }
}
