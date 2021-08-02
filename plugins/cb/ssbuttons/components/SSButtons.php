<?php

    namespace Cb\SSButtons\Components;

    use Lang;
    use Cms\Classes\ComponentBase;

    class SSButtons extends ComponentBase {

        use \Cb\SSButtons\Classes\Shared;
        
        public $defaultSort = ['twitter', 'facebook'];

        public function componentDetails() {
            return [
                'name'        => 'cb.ssbuttons::lang.components.ssbuttons.name',
                'description' => 'cb.ssbuttons::lang.components.ssbuttons.description'
            ];
        }

        public function onRun() {

            # LOAD SHARED "onRun"
            $this->onRunShared();
            
            # LOAD COMPONENT CUSTOM CSS
            $this->addCss('/plugins/Cb/ssbuttons/assets/css/social-sharing.css');

        }

        public function defineProperties() {
            # RETURN SHARED PROPERTIES
            return $this->definePropertiesShared();
        }

    }

?>