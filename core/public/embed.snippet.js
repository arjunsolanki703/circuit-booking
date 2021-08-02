const currentScript = document.currentScript;
const snipletId = currentScript.getAttribute('id');
const url = currentScript.getAttribute('src');
const lang = currentScript.getAttribute('lang');
const baseUrl = new URL(url).origin;

var src = baseUrl+"/public/snippet.html?lang="+lang+"&id="+snipletId;
var iframe = document.createElement('iframe');
iframe.src = src;
iframe.id = "trackdayIframe";
iframe.scrolling = 'no';
iframe.width = '100%';
iframe.frameBorder = 0;
const app = document.getElementsByTagName('app')[0].appendChild(iframe);

var script = document.createElement('script');         
script.src = baseUrl+"/public/iframeResizer.min.js"; 
document.head.appendChild(script)

var script2 = document.createElement('script'); 
script2.src = baseUrl+"/public/iframeResizer.contentWindow.min.js"; 
document.head.appendChild(script2)

var iframe = document.getElementById('trackdayIframe');
var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

document.querySelector('#trackdayIframe').addEventListener("load", ev => {
    IframeLoad();
});

if (  iframeDoc.readyState  == 'complete' ) {
    iframe.contentWindow.onload = function(){
    var style = document.createElement('style');
    style.textContent =
    'body {' +
    '  height: auto;'
    '}' 
    ;
    iframe.contentWindow.document.head.appendChild(style);
        IframeLoad();
    };
} 

function IframeLoad() {
    iFrameResize({
        heightCalculationMethod : 'lowestElement',
        enablePublicMethods     : true
    }, '#trackdayIframe')
}