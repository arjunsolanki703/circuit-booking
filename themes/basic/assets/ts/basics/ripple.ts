import { MDCRipple } from '@material/ripple';

export const isDisabled = function(element) {
  return ($(element).hasClass('disabled') || $(element).prop('disabled'));
};

// @ts-ignore
export const rippleInit = window.rippleInit = (buttons: NodeListOf<Element>) => {
  // check if ripples supported
  const isSupported = isRippleSupported();
  if (!isSupported) {
    console.warn('ripple effect disabled: not supported');
    $(buttons).addClass('ripple-disabled');
    return false;
  }

  if (buttons) {
    for (let i = 0; i < buttons.length; i++) {
      if (!isDisabled(buttons[i])) {
        new MDCRipple(buttons[i]);
      }
    }
  }
};

$(document).ready(function() {
  const cards = document.querySelectorAll('.ripple');

  const buttons = document.querySelectorAll('.button');

  rippleInit(cards);
  rippleInit(buttons);
});


/**
 * detect IE
 * returns version of IE or false, if browser is not Internet Explorer
 */
function isRippleSupported():boolean {
  const ua = window.navigator.userAgent;

  // Test values; Uncomment to check result …

  // IE 10
  // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';

  // IE 11
  // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';

  // Edge 12 (Spartan)
  // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

  // Edge 13
  // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

  const msie = ua.indexOf('MSIE ');
  if (msie > 0) {
    // IE 10 or older => return version number
    return false;
  }

  const trident = ua.indexOf('Trident/');
  if (trident > 0) {
    // IE 11 => return version number
    const rv = ua.indexOf('rv:');
    return false;
  }

  const edge = ua.indexOf('Edge/');
  if (edge > 0) {
    // Edge (IE 12+) => return version number
    return false;
  }
  const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
  if (isSafari) {
    return false;
  }

  // other browser
  return true;
}
