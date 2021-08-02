import 'moment';
const Lightpick = require('lightpick');

$(document).ready(function() {
    const header: JQuery<HTMLElement> = $('.tabs-buttons');
    const content: JQuery<HTMLElement> = $('.data-picker-content');
    let active: boolean = false;

    /**
     * Method to set active tab
     * @param id - id of active tab
     */
    const setTabActive = function(id: string):void {
        const tab: JQuery<HTMLElement> = $(content).find(`#${id}`);
        content.find('.tab-page').removeClass('active');
        tab.addClass('active');
    };

    /**
     * Method that puts dates to fake input after user select dates in picker
     * @param fakeInput - input that displayed for user
     * @param first - first actual input with start date
     * @param second - second actual input with end date
     */
    const fakeData = function(fakeInput: HTMLElement, first: HTMLElement, second: HTMLElement):void {
        $(fakeInput).val(`${$(first).val()} - ${$(second).val()}`);
    };

    /**
     * Method to init date range picker in booking page
     * @param clickedTabButton - jquery item clicked tab header button
     */
    const initPicker = function(clickedTabButton: JQuery<HTMLElement>): void {
        // DESTROYING PREV PICKER
        $('.lightpicker-wrapper').html('');
        // BASE PROPERTIES
        const target: string = clickedTabButton.data('target');
        const pickerSettings: JQuery<HTMLElement> = clickedTabButton.find('.tabs-datapicker');
        const containerID: string = $(pickerSettings).data('container');
        // FIND PICKER INPUTS
        const firstInput: HTMLElement = $(`#${pickerSettings.data('start')}`)[0];
        const secondInput: HTMLElement = $(`#${pickerSettings.data('end')}`)[0];
        const fakeInput: HTMLElement = $(pickerSettings).find('.fake-input')[0];
        // FIND PRESELECT DAYS
        const preselectStart: string = $(pickerSettings).data('preselect-start');
        const preselectEnd: string = $(pickerSettings).data('preselect-end');
        // FIND START AND END DAYS
        let dateMin: string = pickerSettings.data('min');
        let dateMax: string = pickerSettings.data('max');
        // check if booking dates are set
        if (target === 'date-tracked') {
            // hide error message
            $(content).find('#' + target).find('.book-date-required').hide();
            // find booking container
            let bookingPickerSettings: JQuery<HTMLElement> = $('div[data-target="date-booked"]').find('.tabs-datapicker');
            const firstBookingInput: HTMLElement = $(`#${bookingPickerSettings.data('start')}`)[0];
            const secondBookingInput: HTMLElement = $(`#${bookingPickerSettings.data('end')}`)[0];
            // show error if input empty
            if ($(firstBookingInput).val() === "" || $(secondBookingInput).val() === "") {
                $(content).find('#' + target).find('.book-date-required').show();
                return;
            }
            // set range for tracked picker
            dateMin = $(firstBookingInput).val().toString().replace(/(\d+).(\d+).(\d+)/,'$3-$2-$1');
            dateMax = $(secondBookingInput).val().toString().replace(/(\d+).(\d+).(\d+)/,'$3-$2-$1');
        }
        // SET DISABLED DAYS
        const disabled: string = pickerSettings.data('disabled');
        const locale = $('body').data('lang') ? $('body').data('lang') : 'en';
        // DATE PICKER INIT
        const picker = new Lightpick({
            locale: {
                buttons: {
                    prev: '<i class="mdi mdi-chevron-left"></i>',
                    next: '<i class="mdi mdi-chevron-right"></i>',
                },
            },
            field: firstInput,
            secondField: secondInput,
            parentEl: `#${containerID}`,
            singleDate: false,
            format: 'DD.MM.YYYY',
            minDate: dateMin,
            maxDate: dateMax,
            lang: locale,
            disableDates: disabled,
            disabledDatesInRange: disabled.length > 0 ? false : true,
            numberOfMonths: 2,
            hideOnBodyClick: false,
            autoclose: false,
            onOpen: function() {
                const items = document.querySelectorAll('.is-available');
                items[items.length - 1].classList.add('last-available');
            },
            onSelect: function() {
                fakeData(fakeInput, firstInput, secondInput);
                setTimeout(() => {
                    // @ts-ignore
                    const items = window.items =  document.querySelectorAll('.is-available');
                    items[items.length - 1].classList.add('last-available');
                }, 1);
            },
        });

        if (preselectStart && preselectEnd) {
            picker.setDateRange(preselectStart, preselectEnd);
        }
        picker.show();
    };

    // TABS LOGIC - checked
    if (header.length && content.length) {
        const activeEl: JQuery<HTMLElement> = $(header).find('.date-booked-fake-input');
        initPicker(activeEl);

        // event handling
        $(header).find('.tab-button').on('click', function () {
            $(header).find('.tab-button').removeClass('active');
            $(this).addClass('active');
        });
    }
});
