<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterTrackdayTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackdays')) {
            Schema::table('cb_trackdaybooking_trackdays', function ($table) {
                $table->float('vat_value', 4, 2)->change();
                $table->dropColumn(['start_date']);
                $table->dropColumn(['end_date']);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackdays')) {
            Schema::table('cb_trackdaybooking_trackdays', function ($table) {
                $table->float('vat_value', 10, 6)->change();
            });
        }
    }
}
