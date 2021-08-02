<?php namespace Cb\Booking\Updates;

use Cb\Booking\Models\BookingType;
use Db;
use Schema;
use October\Rain\Database\Updates\Seeder;

class SeedBookingTypesTable2 extends Seeder
{
    public function run()
    {
        Db::table('cb_booking_booking_types')->delete();
        BookingType::create([
            'name'      => 'module',
            'pluginname'=> 'cb.booking'
        ]);
        BookingType::create([
            'name'      => 'training',
            'pluginname'=> 'cb.booking'
        ]);
        BookingType::create([
            'name'      => 'moduleinternal',
            'pluginname'=> 'cb.booking'
        ]);
    }
}
