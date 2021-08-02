<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterOrderTrackdayTableLinkToBooking extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_order_trackdays')) {
            Schema::table('cb_trackdaybooking_order_trackdays', function ($table) {
                $table->integer('booking_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_order_trackdays')) {
            Schema::table('cb_trackdaybooking_order_trackdays', function ($table) {
                $table->dropColumn(['booking_id']);
            });
        }
    }
}
