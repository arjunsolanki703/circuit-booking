import 'moment';
const Lightpick = require('lightpick');

const initSingleMonthDatePicker = function(item) {
    const firstInput = $(item).find('.first')[0];
    const secondInput = $(item).find('.second')[0];
    // FIND PRESELECT DAYS
    const preselectStart: string = $(item).data('preselect-start');
    const preselectEnd: string = $(item).data('preselect-end');

    const now = Date.now();
    let min = $(item).data('min');
    if (min < now) {
        min = now;
    }
    const locale = $('body').data('lang') ? $('body').data('lang') : 'en';

    let picker = new Lightpick({
        field: firstInput,
        secondField: secondInput,
        singleDate: $(item).find('.second').length > 0 ? false : true,
        format: 'DD.MM.YYYY',
        lang: locale,
        minDate: min,
        maxDate: $(item).attr('data-max'),
        disableDates: JSON.parse($(item).attr('data-disabled')),
    });

    if (preselectStart && preselectEnd) {
        picker.setDateRange(preselectStart, preselectEnd);
    }
};

setTimeout(() => {
    // other pickers
    const singlePicker = $('.single-date-picker');
    singlePicker.each(function(index) {
        initSingleMonthDatePicker(singlePicker[index]);
    })
}, 300);
