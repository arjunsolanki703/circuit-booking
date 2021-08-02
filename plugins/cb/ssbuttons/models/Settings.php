<?php

    namespace Cb\SSButtons\Models;

    use Model;
    use Lang;

    class Settings extends Model {

        use \October\Rain\Database\Traits\Validation;

        public $rules = [];

        public $attributeNames;
        public $implement      = ['System.Behaviors.SettingsModel'];
        public $settingsCode   = 'cb_ssbuttons_settings';
        public $settingsFields = 'fields.yaml';

        public function __construct() {
            $this->attributeNames = [
                'twitter'     => Lang::get('cb.ssbuttons::lang.settings.twitter'),
                'facebook'    => Lang::get('cb.ssbuttons::lang.settings.facebook'),
                'google+'     => Lang::get('cb.ssbuttons::lang.settings.Google+'),
                'stumbleupon' => Lang::get('cb.ssbuttons::lang.settings.stumbleupon'),
                'linkedin'    => Lang::get('cb.ssbuttons::lang.settings.linkedin'),
            ];
            parent::__construct();
        }

    }

?>