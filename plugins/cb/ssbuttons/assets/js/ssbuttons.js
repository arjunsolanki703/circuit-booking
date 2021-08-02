var title = document.title;
var url   = document.location.href;
var links = document.querySelectorAll('.share-socials-list a');

for(var i = 0; i < links.length; i++) {
    links[i].href = links[i].href.replace(/___title___/g, encodeURI(title));
    links[i].href = links[i].href.replace(/___url___/g  , encodeURI(url));
}
