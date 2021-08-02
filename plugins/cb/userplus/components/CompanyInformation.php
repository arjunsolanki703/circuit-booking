<?php namespace Cb\Userplus\Components;

use Validator;
use ValidationException;
use ApplicationException;
use Cb\UserPlus\Models\Company;
use Cms\Classes\ComponentBase;
use RainLab\User\Components\Account as UserAccount;

use Str;
use Flash;
use Lang;
use Hash;
use Mail;
use URL;
use Request;


class CompanyInformation extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name'        => 'CompanyInformation Component',
            'description' => 'No description provided yet...'
        ];
    }

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
}
