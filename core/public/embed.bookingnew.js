let searchParams = new URLSearchParams(window.location.search)
const currentScript = document.currentScript;
const snipletId = searchParams.get('id');
const url = currentScript.getAttribute('src');
const lang = searchParams.get('lang');
const baseUrl = new URL(url).origin;

localStorage.baseUrl = baseUrl;
localStorage.apiUrl = localStorage.baseUrl + '/api';
localStorage.trackdayApiSnipletId = snipletId;
localStorage.lang = lang;

document.write('<link href="//netdna.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />');

document.write(`<script src="${baseUrl}/public/dist/runtime-es2015.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/runtime-es5.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/polyfills-es5.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/polyfills-es2015.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/styles-es2015.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/styles-es5.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/vendor-es2015.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/vendor-es5.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/main-es2015.js"></script>`);
document.write(`<script src="${baseUrl}/public/dist/main-es5.js"></script>`);
