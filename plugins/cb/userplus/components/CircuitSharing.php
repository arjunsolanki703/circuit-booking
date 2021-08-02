<?php namespace Cb\Userplus\Components;

use Validator;
use ValidationException;
use ApplicationException;
use Cb\Car2db\Models\UserVehicle as UserVehicleModel;
use Cb\Pgmware\Models\BookingType as BookingTypeModel;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use RainLab\Location\Models\Country;
use RainLab\User\Components\Account as UserAccount;
use RainLab\User\Models\UserGroup;
use Responsiv\Currency\Models\Currency as CurrencyModel;
use Cms\Classes\Page;
use Str;
use Flash;
use Lang;
use Hash;
use Mail;
use URL;
use Request;

class CircuitSharing extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name'        => 'CircuitSharing Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        $prop = parent::defineProperties();
        $prop['type'] = [
            'title'       => 'Type of partial',
            'description' => '',
            'type'        => 'string',
            'default'     => 'signin',
        ];
        $prop['cancel'] = [
            'title'       => 'Cancel link',
            'description' => '',
            'type'        => 'string',
            'default'     => URL::previous(),
        ];
        return $prop;
    }

    public function onRun()
    {
        parent::onRun();

        $user = $this->user();
        if(isset($user) && isset($user->id)) {
            $vehicles = UserVehicleModel::where('user_id', $user->id)->get();
            $this->page['userVehicles'] = $vehicles;
        }

        $item = new CircuitSharingModel();
        $this->page['sircuitSharing'] = $item;
        $this->page['bookingTypes'] = BookingTypeModel::lists('id', 'name');
        $this->page['currencyList'] = CurrencyModel::lists('id', 'name');
    }

    public function prepareVars()
    {
        parent::prepareVars();
        $this->page['userGroups'] = $this->getUserGroups();
        $this->page['countriesList'] = $this->getCountries();
        // $this->page['type'] = $this->property('type');
    }

    public function getUserGroups()
    {
        return UserGroup::where('code', '!=', 'guest')
            ->where('code', '!=', 'registered')
            ->get();
    }

    public function getCountries()
    {
        return Country::getNameList();
    }

    public function onRefreshLocation()
    {
        $item = new CircuitSharingModel();
        $item->fill(post());
        $this->page['sircuitSharing'] = $item;
    }

    public function onRefreshVariant()
    {
        $item = new CircuitSharingModel();
        $item->fill(post());
        $this->page['sircuitSharing'] = $item;
        $this->page['vehicleTypes'] = $item->variant ? $item->variant->vehicleTypes->lists('name', 'id') : [];
    }

    public function onSharingCreate()
    {
        $rules = (new CircuitSharingModel)->rules;
        $validation = Validator::make(post(), $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        $item = new CircuitSharingModel();
        $item->fill(post());
        $user = $this->user();
        $item->user_id = $user->id;
        $item->save();

        Flash::success(post('flash', Lang::get('rainlab.user::lang.account.success_saved')));
    }

    public function onSharingChangeAvailability()
    {
        if (! trim(Request::input('id'))) {
            throw new ApplicationException("No valid id");
        }
        $item = CircuitSharingModel::where('id', Request::input('id'))->first();
        if (! $item) {
            throw new ApplicationException("No valid record");
        }
        $item->is_available = !$item->is_available;
        if (!$item->save()) {
            throw new ApplicationException("Connection invalid, try again");
        }
        return 'OK';
    }

    /*
     * Validate input
     */
    public function onRegisterValidStep1()
    {
        try {
            $data = post();
            $rules = $this->userRules;
            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }
}
