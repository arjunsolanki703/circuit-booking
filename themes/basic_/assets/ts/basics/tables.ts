$(document).ready(function() {
    const tables: JQuery<HTMLElement> = $('table');

    $(tables).find('tr').on('click', function() {
        const info: JQuery<HTMLElement> = $(this).find('.mobile-info');

        if (info.hasClass('active')) {
            info.removeClass('active').slideUp(280);
            return false;
        } else {
            $(tables).find('.mobile-info').slideUp(280).removeClass('active');
            info.slideDown(280).addClass('active');
        }
    });
});
