<?php
namespace Cb\Demostripe\Components;

use Cms\Classes\ComponentBase;
use Auth;

class Booktrack extends ComponentBase
{
    public $user;
    public $successparam;

    public function componentDetails()
    {
        return [
            'name'        => 'booktrack Component',
            'description' => 'Booking with Stripe Test Demo'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function init() {
        $this->user = Auth::getUser();

        $this->successparam = get('success');
    }

    public function onRun() {

    }

    public function onCheckUserId() {
        $this->user = Auth::getUser();
    }

    public function onStartStripe() {

        \Stripe\Stripe::setApiKey('sk_test_LpNhxxHOoe4hLrHe0wPHrFBd');

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => "Cucumber from Roger's Farm",
                'amount' => 200,
                'currency' => 'usd',
                'quantity' => 10,
            ]],
            'payment_intent_data' => [
                'application_fee_amount' => 200,
            ],
            'success_url' => 'http://localhost:81/en?success=success',
            'cancel_url' => 'http://localhost:81/en?success=canceled',
        ], [
            'stripe_account' => 'acct_1FWg46AdLZe8A8RW',
        ]);

        return $session;
    }

    public function getSession() {

    }
}
