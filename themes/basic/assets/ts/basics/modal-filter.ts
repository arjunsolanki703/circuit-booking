$(document).ready(function() {
    // GOD forgive me
    const modalFilterCaller: JQuery<HTMLElement> = $('.modal-filter-caller');
    const wrapper: JQuery<HTMLElement> = $('.page-aside');
    const window: JQuery<HTMLElement> = wrapper.find('.circuits-filter');

    if (modalFilterCaller) {
        modalFilterCaller.on('click', function() {
            showModalFilter();
        });
    }

    const animationTime: number = 280;
    const backdrop: JQuery<HTMLElement> = $('<div class=backdrop></div>');

    const showModalFilter = (): void => {
        $('body').css({'overflow': 'hidden', 'position': 'static'});
        wrapper.addClass('active');
        wrapper.append(backdrop);
        wrapper.addClass('show');
        setTimeout(() => {
            window.addClass('show');
        }, animationTime);
        backdrop.on('click', function() {
            hideModalFilter();
        });
    };

    const hideModalFilter = (): void => {
        $('body').css({'overflow': 'visible', 'position': 'relative'});
        window.removeClass('show');
        setTimeout(() => {
            wrapper.removeClass('show');
            setTimeout(() => {
                wrapper.removeClass('active');
                backdrop.remove();
            }, animationTime);
        }, animationTime);
    }
});
