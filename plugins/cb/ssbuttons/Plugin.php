<?php

    namespace Cb\SSButtons;

    use System\Classes\PluginBase;
    use System\Classes\SettingsManager;

    class Plugin extends PluginBase {

        public function pluginDetails() {
            return [
                'name'        => 'cb.ssbuttons::lang.plugin.name',
                'description' => 'cb.ssbuttons::lang.plugin.description',
                'author'      => 'cb',
                'icon'        => 'icon-share-alt'
            ];
        }

/*
        public function registerSettings() {
            return [
                'settings' => [
                    'label'       => 'Cb.ssbuttons::lang.plugin.name',
                    'description' => 'Cb.ssbuttons::lang.plugin.description',
                    'icon'        => 'icon-share-alt',
                    'class'       => '\Cb\SSButtons\Models\Settings',
                    'order'       => 1,
                    'permissions' => ['Cb.ssbuttons.access'],
                    'category'    => 'system::lang.system.categories.system'
                ],
            ];
        }
*/

        public function registerPermissions() {
            return [
                'cb.ssbuttons.access'  => ['tab' => 'system::lang.permissions.name', 'label' => 'cb.ssbuttons::lang.plugin.permissions'],
            ];
        }

        public function registerComponents() {
            return [
                'Cb\SSButtons\Components\SSButtonsSSB' => 'shares'
            ];
        }

    }

?>