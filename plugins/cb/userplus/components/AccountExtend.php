<?php namespace Cb\UserPlus\Components;

use Validator;
use ValidationException;
use ApplicationException;
use RainLab\User\Components\Account as UserAccount;
use RainLab\User\Models\User as UserModel;
use Cms\Classes\ComponentBase;
use RainLab\User\Models\UserGroup;
use RainLab\Location\Models\Country;
use Cb\UserPlus\Models\Company;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\BookingType as BookingTypeModel;
use Cb\Pgmware\Models\VehicleType as VehicleTypeModel;
use Cb\Pgmware\Models\BookingVariant as BookingModel;
use Cb\Car2db\Models\UserVehicle as UserVehicleModel;
use Cb\Car2db\Models\Make as MakeModel;
use Cb\Car2db\Models\Model as CarModel;
use Responsiv\Currency\Models\Currency as CurrencyModel;
use Cms\Classes\Page;
use Str;
use Flash;
use Lang;
use Hash;
use Mail;
use URL;
use Request;
use Illuminate\Support\Facades\Input;

class AccountExtend extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name'        => 'AccountExtend Component',
            'description' => 'Extend forms'
        ];
    }

    protected $userRules = [
        'group' => 'required|exists:user_groups,code',
        'email' => 'required|email|between:6,255|unique:users,email',
        'cb_gender' => 'required|in:female,male,unknown',
        'name' => 'required|between:2,255',
        'surname' => 'between:2,100',
        'cb_function' => 'between:1,100',
        'cb_telephone' => 'required|between:2,20'
    ];

    function defineProperties()
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
    }

    // TODO add seed for roles
    public function onRegister()
    {
        try {
            $data = post();
            if (!isset($data['agree'])) {
                throw new ValidationException(['agree' => 'Required']);
            }
            $rules = $this->userRules;
            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
            $rules = (new Company)->rules;
            $validation = Validator::make($data['company'], $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
            $_POST['password'] = Str::random(6);
            $_POST['send_invite'] = true;

            $redirect = parent::onRegister();
            $user = UserModel::where('email', $_POST['email'])->first();

            if (!$user) {
                throw new ApplicationException("Connection invalid, try again");
            }

            $user->send_invite = true;
            $user->afterCreate();

            $user->surname = $data['surname'];
            $user->cb_gender = $data['cb_gender'];
            $user->cb_function = $data['cb_function'];
            $user->cb_telephone = $data['cb_telephone'];
            $user->groups()->add(UserGroup::whereCode($data['group'])->first());
            
            if (!$user->save()) {
                throw new ApplicationException("Connection invalid, try again");
            }

            $data['company']['user_id'] = $user->id;
            Company::create($data['company']);

            return $redirect;
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    private function createCompany($user)
    {
        try {
            $data = post();
            $rules = (new Company)->rules;
            $validation = Validator::make($data['company'], $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
            $data['company']['user_id'] = $user->id;
            Company::create($data['company']);
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    public function prepareVars()
    {
        parent::prepareVars();
        $this->page['userGroups'] = $this->getUserGroups();
        $this->page['countriesList'] = $this->getCountries();
        $this->page['type'] = $this->property('type');
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

    public function onUpdateCompany()
    {
        $company = Company::where('id', post('company_id'))->first();
        if (!$company) {
            $company = new Company();
            $user = $this->user();
            $company->user_id = $user->id;
        }
        $rules = (new Company)->rules;
        $validation = Validator::make(post('company'), $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        $company->fill(post('company'));
        $company->termsfile = Input::file('termsfile');
        $company->save();

        Flash::success(post('flash', Lang::get('rainlab.user::lang.account.success_saved')));

        /*
         * Redirect
         */
        if ($redirect = $this->makeRedirection()) {
            return '';
        }

        $this->prepareVars();
    }

    /**
     * Trigger the password reset email
     */
    public function onRestorePassword()
    {
        $rules = [
            'email' => 'required|email|between:6,255'
        ];

        $validation = Validator::make(post(), $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        $user = UserModel::findByEmail(post('email'));
        if (!$user || $user->is_guest) {
            throw new ApplicationException(Lang::get(/*A user was not found with the given credentials.*/'rainlab.user::lang.account.invalid_user'));
        }

        $code = implode('!', [$user->id, $user->getResetPasswordCode()]);
        $link = Page::url('profile/login').'?reset=' . $code;

        $data = [
            'name' => $user->name,
            'link' => $link,
            'code' => $code
        ];

        Mail::send('rainlab.user::mail.restore', $data, function($message) use ($user) {
            $message->to($user->email, $user->full_name);
        });
    }
}
