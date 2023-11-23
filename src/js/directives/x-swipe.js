import Alpine from 'alpinejs';

Alpine.directive('swipe', (el, { value, modifiers, expression }) => {

  let swipeEvents = [];
  const threshold = 50;

  // Define our custom events.
  const swipeLeft = new Event('swipeleft');
  const swipeRight = new Event('swiperight');

  let startEvents = ['touchstart'];
  let endEvents = ['touchend'];

  if (modifiers.includes('click')) {
    startEvents.push('mousedown');
    endEvents.push('mouseup');
  }

  startEvents.forEach((name) => {
    el.addEventListener(name, (e) => {
      let t = (e.type == "mousedown") ? { clientX: e.clientX, clientY: e.clientY } : e.touches[0];
      // Capture the start of the swipe
      swipeEvents.push(t);

    }, { passive: true });
  });

  endEvents.forEach((name) => {
    el.addEventListener(name, (e) => {

      let t = (e.type == "mouseup") ? { clientX: e.clientX, clientY: e.clientY } : e.changedTouches[0];

      // Capture the end of the swipe
      swipeEvents.push(t);

      // Get the swipe differences
      let xSwipe = swipeEvents[1].clientX - swipeEvents[0].clientX;
      let ySwipe = swipeEvents[1].clientY - swipeEvents[0].clientY;

      if (Math.abs(xSwipe) > threshold) {
        if (xSwipe < 0) {
          el.dispatchEvent(swipeLeft);
        } else if (xSwipe > 0) {
          el.dispatchEvent(swipeRight);
        }
      }

      // Reset our event array.
      swipeEvents = [];

    }, { passive: true });
  })

});