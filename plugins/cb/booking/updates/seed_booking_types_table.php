<?php namespace Cb\Booking\Updates;

use Cb\Booking\Models\BookingType;
use Schema;
use October\Rain\Database\Updates\Seeder;

class SeedBookingTypesTable extends Seeder
{
    public function run()
    {
        BookingType::create([
            'name'      => 'module'
        ]);
        BookingType::create([
            'name'      => 'training'
        ]);
        BookingType::create([
            'name'      => 'moduleinternal'
        ]);
    }
}
