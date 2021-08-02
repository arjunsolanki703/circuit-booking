<?php namespace Cb\Booking\Updates;

use RainLab\User\Models\UserGroup;
use October\Rain\Database\Updates\Migration;
use Schema;
use DB;

class SeedAddRainlabUsergroupTrackdayorganizer extends Migration
{
    public function up()
    {
        UserGroup::create([
            'name'          => 'Trackday Organizer',
            'code'    =>  'cb_trackday_organizer',
            'description'    =>  'Trackday Organizer = Trackday Anbieter für das Plugin cb.trackdaybooking'
        ]);
    }

    public function down()
    {
        DB::table('user_groups')->where('code', '=','cb_trackday_organizer')->delete();
    }
}
