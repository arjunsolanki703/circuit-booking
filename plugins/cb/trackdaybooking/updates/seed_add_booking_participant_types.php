<?php namespace Cb\Booking\Updates;

use Cb\Booking\Models\ParticipantType;
use October\Rain\Database\Updates\Migration;
use Schema;
use DB;

class SeedAddBookingParticipantTypes extends Migration
{
    public function up()
    {
        ParticipantType::create([
            'name'          => 'cb_trackdaybooking_trackdayorganizer'
        ]);
        /*
        ParticipantType::create([
            'name'          => 'cb_trackdaybooking_trackdayparticipant'
        ]);
        */
    }

    public function down()
    {
        DB::table('cb_booking_participant_types')->where('name', '=','cb_trackdaybooking_trackdayorganizer')->delete();
        //DB::table('cb_booking_participant_types')->where('name', '=','cb_trackdaybooking_trackdayparticipant')->delete();
    }
}
