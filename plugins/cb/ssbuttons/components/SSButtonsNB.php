<?php

    namespace Cb\SSButtons\Components;

    use Lang;
    use Cms\Classes\ComponentBase;

    class SSButtonsNB extends ComponentBase {

        use \Cb\SSButtons\Classes\Shared;

        public $defaultSort = ['twitter', 'facebook', 'google+', 'stumbleupon', 'linkedin'];

        public function componentDetails() {
            return [
                'name'        => 'cb.ssbuttons::lang.components.ssbuttonsnb.name',
                'description' => 'cb.ssbuttons::lang.components.ssbuttonsnb.description'
            ];
        }

        public function onRun() {

            # LOAD SHARED "onRun"
            $this->onRunShared();

            # LOAD COMPONENT CUSTOM CSS
            $this->addCss('/plugins/cb/ssbuttons/assets/css/social-sharing-nb.css');

        }

        public function defineProperties() {
            # RETURN SHARED PROPERTIES
            return $this->definePropertiesShared();
        }

    }

?>