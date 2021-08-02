<?php namespace Cb\Booking\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * BookingParticipant Form Widget
 */
class BookingParticipant extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'cb_booking_booking_participant';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('bookingparticipant');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/bookingparticipant.css', 'cb.booking');
        $this->addJs('js/bookingparticipant.js', 'cb.booking');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
