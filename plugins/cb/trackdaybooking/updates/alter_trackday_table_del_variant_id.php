<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterTrackdayTableDelVariantId extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackdays')) {
            Schema::table('cb_trackdaybooking_trackdays', function ($table) {
                $table->dropColumn(['variant_id']);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackdays')) {
            Schema::table('cb_trackdaybooking_trackdays', function ($table) {
                $table->integer('variant_id');
            });
        }
    }
}
