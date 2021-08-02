<?php namespace Cb\Userplus\Components;

use Validator;
use ValidationException;
use ApplicationException;
use RainLab\User\Components\Account as UserAccount;
use Cb\UserPlus\Components\AccountExtend;
use Cms\Classes\Page;
use Str;
use Flash;
use Lang;
use Hash;
use Mail;
use URL;
use Request;


class UpdatePasswort extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name'        => 'UpdatePasswort Component',
            'description' => 'No description provided yet...'
        ];
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
