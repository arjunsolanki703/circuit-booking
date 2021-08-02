import { rippleInit } from "./ripple";

/**
 * interface for hidden json data
 */
interface hiddenJSON {
    circuit_sharing_id: string;
    circuit_sharing_name: string;
    is_lastminute: string;
}

/**
 * Class that describes modal object with hide and show behaviour
 * @param modal - jquery modal HTML node object
 */
export class Modal {
    private modal: JQuery<HTMLElement>;
    private id: string;
    private animationDelay: number;
    private closeOnBackdrop: boolean;

    constructor(modal: JQuery<HTMLElement>) {
        this.modal = modal;
        this.id = $(modal).attr('id');
        this.animationDelay = 280;
        this.closeOnBackdrop = true;
    }

    setCloseOnBD = (closable: boolean):void => {
        this.closeOnBackdrop = closable;
    };

    isClosableOnBD = (): boolean => {
        return this.closeOnBackdrop;
    };

    getModalID = ():string => {
        return this.id;
    };

    show = (hidden?: hiddenJSON):void => {
        if (hidden) {
            // sharing hidden inputs
            const hiddenID: JQuery<HTMLElement> = $(this.modal).find('#circuit_sharing_id');
            const hiddenName: JQuery<HTMLElement> = $(this.modal).find('#circuit_sharing_name');
            const hiddenLastminute: JQuery<HTMLElement> = $(this.modal).find('#is_lastminute');

            hiddenID.val(hidden.circuit_sharing_id);
            hiddenName.val(hidden.circuit_sharing_name);
            hiddenLastminute.val(hidden.is_lastminute);
        }
        // init ripple cause we appended new buttons to document
        const buttons = document.querySelectorAll('.modal-wrapper .button');
        rippleInit(buttons);
        // enable submit button
        $(this.modal).find('button[type=submit]').removeAttr('disabled');
        // removing previous alerts
        $(this.modal).find('.success-alert').remove();
        $(this.modal).find('.error-alert').remove();
        // disable body from scroll
        $('body').css({'overflow': 'hidden'});
        $(this.modal).addClass('active');
        setTimeout(() => {
            $(this.modal).addClass('show');
        }, this.animationDelay);
    };

    hide = ():void => {
        // enable body scrolling
        $('body').css({'overflow': 'visible'});
        $(this.modal).removeClass('show');
        if ($(this.modal).find('form').length > 0) {
            var resetForm = <HTMLFormElement>document.getElementById(this.getModalID()).getElementsByTagName('form')[0];
            resetForm.reset();
            if ($(this.modal).find('form').find('select').length > 0) {
                $(this.modal).find('form').find('select option:first-child').prop('selected', true);
            }
        }

        setTimeout(() => {
            $(this.modal).removeClass('active');
        }, this.animationDelay);
        this.setCloseOnBD(true);
    };
}

/**
 * Method that finds all modal callers and handle click events on them
 * @param buttons - array of jquery objects
 * @param modals - array of Modal objects
 */
// @ts-ignore
const modalCallerInit = window.modalCallerInit = (buttons: JQuery<HTMLElement>, modals: Modal[]):boolean => {
    if (!buttons.length) {
        return false;
    }

    buttons.on('click', function() {
        const target = $(this).data('target');
        if (!target) {
            console.warn('caller button failure: caller button got no target');
            return false;
        }

        const item: Modal = modals.find(modal => modal.getModalID() === target);
        if (!item) {
            console.warn(`caller button failure: no modal with id ${target}`);
            return false;
        }

        // sharing hidden inputs
        const hiddenInputJSON: hiddenJSON = $(this).data('hiddeninput');
        if (hiddenInputJSON) {
            item.show(hiddenInputJSON);
        } else {
            item.show();
        }
    });
};

/**
 * Method that find all modals elements and create a Modal objects with them
 * @param modals - array of jquery objects
 * @return Modal[] - array of Modal objects
 */
// @ts-ignore
const modalsInit = window.modalsInit = (modals: JQuery<HTMLElement>): Modal[] => {
    if (!modals.length) {
        return [];
    }

    let items = [];
    modals.each(function() {
        if (!$(this).attr('id')) {
            console.warn('Cannot init modal: modal has no id');
            return false;
        }

        items.push(new Modal($(this)));
    });

    return items;
};

/**
 * Method that find all modal backdrops and handles click events
 * @param backdrops - array of jquery objects
 * @param modals - array of Modal objects
 */
// @ts-ignore
const backdropsInit = window.backdropsInit = (backdrops: JQuery<HTMLElement>, modals: Modal[]): boolean => {
    if (!backdrops.length) {
        return false;
    }

    backdrops.each(function() {
        $(this).on('click', function() {
            const targetID = $(this).closest('.modal').attr('id');
            if (!targetID) {
                console.warn('Cannot close modal: modal has no id');
                return false;
            }

            const item = modals.find(item => item.getModalID() === targetID);
            item.hide();
        })
    });
};

/**
 * Method that find all close modal buttons and handles click event
 * @param closeButtons - array of jquery objects
 * @param modals - array of Modal objects
 */
// @ts-ignore
const modalCloseInit = window.modalCloseInit = (closeButtons: JQuery<HTMLElement>, modals: Modal[]): boolean => {
    if (!closeButtons.length) {
        return false;
    }

    closeButtons.each(function() {
        $(this).on('click', function() {
            const targetID = $(this).closest('.modal').attr('id');
            if (!targetID) {
                console.warn('Cannot close modal: modal has no id');
                return false;
            }
            const item = modals.find(item => item.getModalID() === targetID);
            item.hide();
        })
    })
};

$(document).ready(function() {
    const modalCallers = $('.modal-caller');
    const modalsHTML = $('.modal');
    const backdrops = $('.modal-backdrop');
    const modalClose = $('.close-modal');

    // @ts-ignore
    const modals: Modal[] = window.modals = modalsInit(modalsHTML);
    modalCallerInit(modalCallers, modals);
    backdropsInit(backdrops, modals);
    modalCloseInit(modalClose, modals);
});
