<?php namespace Cb\Booking\Updates;

use Cb\Booking\Models\ParticipantType;
use Cb\Trackdaybooking\Models\OrderTrackday;
use Cb\Trackdaybooking\Models\OrderTrackdayTypes;
use October\Rain\Database\Updates\Migration;
use Schema;
use DB;

class SeedAddOrderTrackdayTypes extends Migration
{
    public function up()
    {
        OrderTrackdayType::create([
            'name'          => 'blueprint'
        ]);

        OrderTrackdayType::create([
            'name'          => 'ordertrackday'
        ]);
    }

    public function down()
    {
        DB::table('cb_booking_booking_types')->where('name', '=','blueprint')->delete();
        DB::table('cb_booking_booking_types')->where('name', '=','ordertrackday')->delete();
    }
}
