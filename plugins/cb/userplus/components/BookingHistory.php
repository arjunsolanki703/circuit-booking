<?php namespace Cb\Userplus\Components;

use Validator;
use ValidationException;
use ApplicationException;
use Cb\Car2db\Models\Make as MakeModel;
use Cb\Car2db\Models\Model as CarModel;
use Cb\Car2db\Models\UserVehicle as UserVehicleModel;
use Cb\Pgmware\Models\BookingType as BookingTypeModel;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cms\Classes\ComponentBase;
use RainLab\User\Components\Account as UserAccount;
use Responsiv\Currency\Models\Currency as CurrencyModel;
use Cms\Classes\Page;
use Str;
use Flash;
use Lang;
use Hash;
use Mail;
use URL;
use Request;

class BookingHistory extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name'        => 'BookingHistory Component',
            'description' => 'No description provided yet...'
        ];
    }
}
