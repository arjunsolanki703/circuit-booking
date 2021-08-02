export class AsideMenu {
    callers: JQuery<HTMLElement>;
    closeButtons: JQuery<HTMLElement>;
    aside: JQuery<HTMLElement>;
    animationTime: number;

    constructor(callers: JQuery<HTMLElement>, closeButtons: JQuery<HTMLElement>,  aside: JQuery<HTMLElement>) {
        this.callers = callers;
        this.closeButtons = closeButtons;
        this.aside = aside.first();
        this.animationTime = 280;
    }

    /**
     * Method to show aside menu
     */
    show = (): void => {
        // disable body from scroll
        const body = $('body');
        body.css({'overflow': 'hidden', 'position': 'static'});
        this.aside.addClass('active');
        const backdrop = body.append('<div class=body-backdrop></div>');
    };

    /**
     * Method to hide aside menu
     */
    hide = (): void => {
        // return body from scroll
        $('body').css({'overflow': 'visible', 'position': 'relative'});
        this.aside.removeClass('active');
        $('.body-backdrop').remove();
    };
}

$(document).ready(function() {
    const aside = $('.mobile-aside');
    const callers = $('.mobile-aside-caller');
    const closeButtons = $('.mobile-aside-close');
    // init
    const mobileAside = new AsideMenu(callers, closeButtons, aside);
    // event listeners
    mobileAside.callers.on('click', function() {
        mobileAside.show();
        $(document).find('.body-backdrop').on('click', function() {
           mobileAside.hide();
        });
    });
    mobileAside.closeButtons.on('click', function() {
        mobileAside.hide();
    });
});
