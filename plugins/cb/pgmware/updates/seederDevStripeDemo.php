<?php namespace Cb\Pgmware\Updates;

use Seeder;
use DB;
use  Cb\Pgmware\Models\UserStripe;

class seederDevStripeDemo extends Seeder
{
    public function run()
    {
       //Location::truncate();
       //DB::table('cb_pgmware_locations')->delete();

        UserStripe::create([
            'stripe_user_id'            => 'acct_1FbopYDi4VKRP6Yw',
            'user_id'                  => 2
        ]);

        UserStripe::create([
            'stripe_user_id'            => 'acct_1FWg46AdLZe8A8RW',
            'user_id'                  => 4
        ]);
    }
}