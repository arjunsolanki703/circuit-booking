<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterTrackdayCapacitiesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackday_capacities')) {
            Schema::table('cb_trackdaybooking_trackday_capacities', function ($table) {
                $table->dropColumn(['bookable_from']);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackday_capacities')) {
            Schema::table('cb_trackdaybooking_trackday_capacities', function ($table) {
                $table->string('bookable_from');
            });
        }
    }
}
