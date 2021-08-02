<?php namespace Cb\Userplus\Components;

use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use RainLab\User\Components\Account as UserAccount;
use Str;
use Flash;
use Lang;
use Hash;
use Mail;
use URL;
use Request;


class ProfileInformation extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name'        => 'ProfileInformation Component',
            'description' => 'No description provided yet...'
        ];
    }

    private $userRules = [
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
    }

    public function onUpdate()
    {
        if (strlen(post('password'))) {
            $user = $this->user();
            if (! Hash::check(post('current_password'), $user->password)) {
                throw new ValidationException(['current_password' => 'Wrong current password']);
            }
        }
        return parent::onUpdate();
    }
}
