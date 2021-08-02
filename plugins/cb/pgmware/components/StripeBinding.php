<?php


namespace Cb\Pgmware\Components;
use Cb\Pgmware\Models\UserStripe as UserStripeModel;

/**
 * @deprecated Do NOT use StripeBinding it is not actual Library.
 * @package Cb\Pgmware\Components
 */
class StripeBinding
{
    private static $APPLICATION_FEE_AMOUNT = 2000;
    //


    public static function onBookStripeWithUser($name, $discription, $amount, $user_id) {

        $usm = UserStripeModel::where('user_id', $user_id)->first();

        if (empty($usm) || empty($usm->stripe_user_id)) {
            throw new Exception('Invalid Stripe User');
            die();
        }
        return self::onBookStripe($name, $discription, $amount, $usm->stripe_user_id);
    }


    public static function onBookStripe($name, $discription, $amount, $stripe_account) {

        \Stripe\Stripe::setApiKey('sk_test_LpNhxxHOoe4hLrHe0wPHrFBd');

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => $name,
                'description' => $discription,
                'amount' => $amount,
                'currency' => 'EUR',
                'quantity' => 1,
            ]],
            'payment_intent_data' => [
                'application_fee_amount' => self::$APPLICATION_FEE_AMOUNT,
            ],
            'success_url' => 'http://localhost:81/en?success=success',
            'cancel_url' => 'http://localhost:81/en?success=canceled',
        ], [
            /*'stripe_account' => 'acct_1FWg46AdLZe8A8RW',*/
            'stripe_account' => $stripe_account,
        ]);

        $out = array();
        $out["session"] = $session;
        $out["account"] = $stripe_account;

        return $out;
    }
}
