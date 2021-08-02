<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterTrackdayCapacitiesTableLinkToOrder extends Migration
{

    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackday_capacities')) {
            Schema::table('cb_trackdaybooking_trackday_capacities', function ($table) {
                $table->dropColumn(['trackday_id']);
                $table->integer('order_trackday_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackday_capacities')) {
            Schema::table('cb_trackdaybooking_trackday_capacities', function ($table) {
                $table->dropColumn(['order_trackday_id']);
                $table->integer('trackday_id');
            });
        }
    }
}
