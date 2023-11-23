import Alpine from 'alpinejs';

Alpine.magic('scrollTo', () => $el => {

  if (!window.elementInViewport($el)) {
    window.scrollToElement($el);
  }

});

window.elementInViewport = function ($el) {

  var bounding = $el.getBoundingClientRect();
  var $elHeight = $el.offsetHeight;
  var $elWidth = $el.offsetWidth;

  if (bounding.top >= -$elHeight
    && bounding.left >= -$elWidth
    && bounding.right <= (window.innerWidth || document.documentElement.clientWidth) + $elWidth
    && bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) + $elHeight) {

    return true;

  }

  return false;

}


//---------------------------------------------------------------------------------------[ SMOOTH SCROLLING ]

/**
 * Here we have a simple function that will allow us to scroll to a specific element. 
 */
window.scrollToElement = function (target) {

  if (!target) { return false; }

  console.log($el);

  var $el = target.tagName === undefined ? document.querySelector(target) : target,
    $header = document.querySelector('header'),
    coords = window.getCoords($el),
    offsetHeight = 10,
    offsetTop = coords.top;

  scroll({
    top: (offsetTop - offsetHeight),
    behavior: "smooth"
  });

}


//------------------------------------------------------------------------------------------[ WINDOW COORDS ]

/**
 * Here we have a simple function that will allow us to scroll to a specific element.
 */
window.getCoords = function ($e) { // crossbrowser version

  var box = $e.getBoundingClientRect();

  var body = document.body;
  var docEl = document.documentElement;

  var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
  var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

  var clientTop = docEl.clientTop || body.clientTop || 0;
  var clientLeft = docEl.clientLeft || body.clientLeft || 0;

  var top = box.top + scrollTop - clientTop;
  var left = box.left + scrollLeft - clientLeft;

  return { top: Math.round(top), left: Math.round(left) };

}

//---------------------------------------------------------------------------------------------[ GET PARAMS ]

/**
 * Here we have a simple function to get parameters from the query string.
 * This sort of function is useful in running 
 */
window.getParam = function (name, url) {

  if (!url) { url = window.location.href; }

  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url);

  if (!results) { return null; }
  if (!results[2]) { return ''; }

  return decodeURIComponent(results[2].replace(/\+/g, ' '));

}

//---------------------------------------------------------------------------------------------[ ~ FIN ~ ]