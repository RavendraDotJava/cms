/**
 * Directive: x-fx
 *
 * This custom directive is used to implement simple "enter" animations for elements
 * across the site. It's usage is relatively simple, but requires three properties within
 * the html:
 *
 * x-data - this can be either empty or can initialize its own component.
 *
 * x-fx-cloak - this is a custom cloaking attribute, which introduces basic styles
 *   (defined in /sass/globals/_fx.scss) for initial state. It is removed by the directive.
 *
 * x-fx - this is the directive itself. It accepts an expression and a modifier. The expression
 *   defines the distance that the effect should travel (any CSS units will work). The modifier
 *   defines the direction that the effection should travel. Valid motifiers include
 *
 *   - up - (default) the element will transition up
 *   - down - the element will transition down
 *   - left - the element will transition in from the left
 *   - right - the element will transition in from the right
 *   - scale - the element will scale up to its automatic size
 *
 */

import Alpine from 'alpinejs';

// Add the fx array.
// This becomes a global collection of all elements that initialize the x-fx direction
Alpine.fx = [];

// Define the debounce property
Alpine.fxBounce = false;

// Define the event handler function
Alpine.fxScroll = ($event, percentage) => {

  if (Alpine.fxBounce) { return true; }

  Alpine.fxBounce = setTimeout(() => {
    Alpine.fxBounce = false;
  }, (percentage === 1 ? 1200 : 150));


  for (var f = 0; f < Alpine.fx.length; f++) {

    let $el = Alpine.fx[f];

    if ($el) {
      if (percentage === undefined) { percentage = .9; }
      let position = $el.getBoundingClientRect();
      let fold = (window.innerHeight * percentage);
      if (position.top < fold) {
        $el.style.transform = '';
        $el.classList.add('fx-in');
        Alpine.fx[f] = false;
      }
    }
  }
}

// Add the scroll event hanlder, which uses the fxScroll function to check for
// items that should be transitioned in as the user scrolls.
window.addEventListener('scroll', Alpine.fxScroll);


// Define our directive.
Alpine.directive('fx', ($el, { value, modifiers, expression }) => {

  $el.classList.add('fx');
  $el.removeAttribute('x-fx-cloak');

  const direction = modifiers[0] ? modifiers[0] : 'left';
  const duration = modifiers[1] ? modifiers[1] : 1000;
  const distance = expression ? expression : '2rem';

  switch (direction) {
    case 'right':
      $el.style.transform = 'translate3d(' + distance + ', 0, 0)';
      break;
    case 'bottom':
      $el.style.transform = 'translate3d(0, ' + distance + ', 0)';
      break;
    case 'top':
      $el.style.transform = 'translate3d(0, -' + distance + ', 0)';
      break;
    case 'scale':
        $el.style.transform = 'scale(' +  distance + ')';
        break;
    default:
      $el.style.transform = 'translate3d(-' + distance + ', 0, 0)';
      break;
  }

  $el.style.transitionDuration = (duration / 1000) + 's';

  Alpine.fx.push($el);

  requestAnimationFrame(() => {
    setTimeout(() => {
      Alpine.fxScroll({}, 1);
    }, 300)
  });

});