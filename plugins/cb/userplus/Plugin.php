<?php namespace Cb\UserPlus;

use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
use Cb\UserPlus\Models\Company as CompanyModel;
use RainLab\Location\Models\Country as CountryModel;
use Lang;
use Event;

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    public function registerComponents()
    {
        return [
            'Cb\UserPlus\Components\AccountExtend' => 'registration',
            'Cb\UserPlus\Components\UpdatePasswort' => 'updatepasswort',
            'Cb\UserPlus\Components\CircuitSharing' => 'profilcircuitsharing',
            'Cb\UserPlus\Components\BookingHistory' => 'profilbookinghistory',
            'Cb\UserPlus\Components\ProfileInformation' => 'profileinformation',
            'Cb\UserPlus\Components\CompanyInformation' => 'companyinformation'
        ];
    }

    /*
    public function registerSettings()
    {
    }
    */
    
    public function boot()
    {
        Event::listen('backend.menu.extendItems', function($manager) {
            $manager->addSideMenuItems('RainLab.User', 'user', [
                'users' => [
                    'label' => 'Users',
                    'icon' => 'icon-user',
                    'url' => '/backend/rainlab/user/users'
                ]
            ]);
        });
        Event::listen('backend.menu.extendItems', function($manager) {
            $manager->addSideMenuItems('RainLab.User', 'user', [
                'companies' => [
                    'label' => 'Company',
                    'icon' => 'icon-user-plus',
                    'url' => '/backend/cb/userplus/companies'
                ]
            ]);
        });
        UserModel::extend(function($model)
        {
            $model->addFillable([
                'cb_gender',
                'cb_telephone',
                'cb_last_name',
                'cb_function',
            ]);
            $model->hasOne['company'] = ['Cb\UserPlus\Models\Company'];
            $model->hasOne['location'] = ['Cb\Pgmware\Models\Location'];
            $model->hasMany['booking'] = ['Cb\Pgmware\Models\BookingVariant', 'scope' => 'makeForProfile'];
            $model->hasMany['sharing'] = ['Cb\Pgmware\Models\CircuitSharing', 'scope' => 'makeForProfile'];
        });
        UsersController::extendFormFields(function($form, $model, $context)
        {
            if (!$model instanceof UserModel) {
                return;
            }
            $form->addTabFields([
                'cb_gender' => [
                    'label'   => 'cb.userplus::lang.personal.gender',
                    'tab'     => 'cb.userplus::lang.personal.tab',
                    'type'    => 'dropdown',
                    'options' => [
                        'unknown' => Lang::get('cb.userplus::lang.gender.unknown'),
                        'female'  => Lang::get('cb.userplus::lang.gender.female'),
                        'male'    => Lang::get('cb.userplus::lang.gender.male')
                    ],
                    'span'    => 'auto'
                ],
                'cb_telephone' => [
                    'label' => 'cb.userplus::lang.personal.telephone',
                    'tab'   => 'cb.userplus::lang.personal.tab',
                    'span'  => 'auto'
                ],
                'cb_last_name' => [
                    'label' => 'cb.userplus::lang.personal.last_name',
                    'tab'   => 'cb.userplus::lang.personal.tab',
                    'span'  => 'auto'
                ]
            ]);
        });
    }
}
