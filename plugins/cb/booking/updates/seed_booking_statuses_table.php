<?php namespace Cb\Booking\Updates;

use Cb\Booking\Models\BookingStatus;
use Schema;
use October\Rain\Database\Updates\Seeder;

class SeedBookingStatusesTable extends Seeder
{
    public function run()
    {
        BookingStatus::create([
            'name'      => 'Reserved',
            'order'     => 1
        ]);
        BookingStatus::create([
            'name'      => 'Cancelled',
            'order'     => 3
        ]);
        BookingStatus::create([
            'name'      => 'Confirmed',
            'order'     => 5
        ]);
        BookingStatus::create([
            'name'      => 'Active',
            'order'     => 7
        ]);
        BookingStatus::create([
            'name'      => 'Closed',
            'order'     => 9
        ]);
        BookingStatus::create([
            'name'      => 'Fully paid',
            'order'     => 11
        ]);
        BookingStatus::create([
            'name'      => 'Request',
            'order'     => 13
        ]);
        BookingStatus::create([
            'name'      => 'Paused',
            'order'     => 15
        ]);

    }
}
