<?php

    namespace Cb\SSButtons\Components;

    use Lang;
    use Cms\Classes\ComponentBase;

    class SSButtonsSSB extends ComponentBase {

        use \Cb\SSButtons\Classes\Shared;

        public $defaultSort = ['facebook', 'twitter', 'email'];

        public function componentDetails() {
            return [
                'name'        => 'cb.ssbuttons::lang.components.ssbuttonsssb.name',
                'description' => 'cb.ssbuttons::lang.components.ssbuttonsssb.description'
            ];
        }

        public function onRun() {

            # LOAD SHARED "onRun"
            $this->onRunShared();

            # LOAD COMPONENT CUSTOM CSS
            $this->addCss('/plugins/cb/ssbuttons/assets/css/social-sharing-ssb.css');

        }

        public function onRender() {
            # ICONS TYPE
            $this->page['type'] = (strpos($this->properties['theme'], 'svg') ? 'svg' : 'png');
        }

        public function defineProperties() {

            # GET SHARED PROPERTIES
            $properties = $this->definePropertiesShared();
            
            # REMOVE FA ON THIS COMPONENT
            unset($properties['fa']);

            # THEME
            $properties['theme'] = [
                'title'             => 'Icons theme',
                'type'              => 'dropdown',
                'default'           => 'flat_web_icon_set_color',
                'placeholder'       => 'Select icons theme',
                'showExternalParam' => false
            ];

            return $properties;

        }

    }

?>
