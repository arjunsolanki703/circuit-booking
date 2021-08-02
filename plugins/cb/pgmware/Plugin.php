<?php namespace Cb\Pgmware;

use System\Classes\PluginBase;
use RainLab\Location\Models\Country as CountryModel;
use Cb\Pgmware\Models\Continent as ContinentModel;
use RainLab\Location\Controllers\Locations as LocationsController;
use Cb\Pgmware\Models\CircuitSharing as CircuitSharingModel;
use Cb\Pgmware\Models\Lastminute as LastminuteModel;
use Lang;
use Event;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Location'];

    public function registerComponents()
    {
        return [
            'Cb\Pgmware\Components\Continents' => 'continents',
            'Cb\Pgmware\Components\Continent' => 'continent',
            'Cb\Pgmware\Components\Country' => 'country',
            'Cb\Pgmware\Components\Location' => 'location',
            'Cb\Pgmware\Components\Filter' => 'filter',
            'Cb\Pgmware\Components\FilterCircuits' => 'filterCircuits',
            'Cb\Pgmware\Components\FilterSharing' => 'filterSharing',
            'Cb\Pgmware\Components\FilterTrackday' => 'filterTrackday',
            'Cb\Pgmware\Components\Booking' => 'booking',
            'Cb\Pgmware\Components\FeaturedLocation' => 'featuredLocation',
        ];
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        CountryModel::extend(function($model)
        {
            $model->translatable = array_merge($model->translatable, ['cb_slug']);
            $model->addFillable([
                'cb_continent_id',
                'cb_slug'
            ]);
            $model->belongsTo['continent'] = ['Cb\Pgmware\Models\Continent', 'key' => 'cb_continent_id'];
            $model->hasMany['location'] = ['Cb\Pgmware\Models\Location', 'key' => 'country_id'];
        });
        LocationsController::extendFormFields(function($form, $model, $context)
        {
            if (!$model instanceof CountryModel) {
                return;
            }
            $form->addFields([
                'cb_slug' => [
                    'label' => 'cb.pgmware::lang.default.slug',
                    'span' => 'auto',
                    'preset' => [
                        'field' => 'name',
                        'type' => 'slug'
                    ],
                    'type' => 'text'
                ],
                'cb_continent_id' => [
                    'label' => 'cb.pgmware::lang.default.continent',
                    'type' => 'dropdown',
                    'span' => 'auto',
                    'options' => ContinentModel::getNameList(),
                ],
                'cb_description' => [
                    'label' => 'cb.pgmware::lang.default.description',
                    'type' => 'textarea',
                    'span' => 'auto'
                ]
            ]);
        });
        /**
        * Extensions for Sitemap
        */
        Event::listen('pages.menuitem.listTypes', function()
        {
            return [
                'continent-page' => 'cb.pgmware::lang.default.continent'
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type)
        {
            if ($type == 'continent-page') {
                return ContinentModel::getMenuTypeInfo($type);
            }
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme)
        {
            if ($type == 'continent-page') {
                return ContinentModel::resolveMenuItem($item, $url, $theme);
            }
        });

        \Event::listen('martin.forms.beforeSaveRecord', function (&$formdata, $component) {
            if (isset($formdata['circuit_sharing_id'])) {
                if ($formdata['is_lastminute'] === '1') {
                    $obj = $formdata['circuit_sharing_id'];
                    $obj = LastminuteModel::where('id', $obj)->first();

                    $formdata['Last_minute_booking_id'] = $formdata['circuit_sharing_id'];
                    unset($formdata['circuit_sharing_id']);
                    unset($formdata['circuit_sharing_name']);
                } else {
                    $obj = $formdata['circuit_sharing_id'];
                    $obj = CircuitSharingModel::where('id', $obj)->first();
                }
                unset($formdata['is_lastminute']);
                if ($obj) {
                    $email = $obj->user->email;
                    // Override component mail recipients
                    $component->setProperty('mail_recipients', [$email]);
                }
            }
        });
    }
}
