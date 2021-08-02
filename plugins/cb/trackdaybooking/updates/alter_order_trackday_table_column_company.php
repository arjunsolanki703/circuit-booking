<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterOrderTrackdayTableColumnCompany extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackdays')) {
            Schema::table('cb_trackdaybooking_trackdays', function ($table) {
                $table->renameColumn('companie_id', 'company_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('cb_trackdaybooking_trackdays')) {
            Schema::table('cb_trackdaybooking_trackdays', function ($table) {
                $table->renameColumn('company_id', 'companie_id');
            });
        }
    }
}
