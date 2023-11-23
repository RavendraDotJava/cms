/**
 * Magic: breakpoint()
 * 
 * This magic function is intended as a means of checking against one of the 
 * same set of media queries used by TailwindCSS. The idea is to provide a single,
 * easily repeatable function available to all Alpine components. This way, they
 * don't need to implement this functionality on an individual basis.
 * 
 * Because this magic function is intended to integrate with the same media queries
 * that power TailwindCSS, this function relies on the existance of the 
 * mediaqueries.json file, and the assumption that this same file is imported
 * into the Tailwind config file.
 */

import Alpine from 'alpinejs';

// Defines the screen require
const screens = require('../../../mediaqueries.json');

/**
 * Function: screensToQueries()
 * 
 * This helper function takes the basic "screens" object defined in the 
 * mediaqueries.json file and converts each item into an actual media query string. 
 * It then returns an object in which each defined property is an instance of the
 * matchMedia Object, which checks against the given media query.
 * 
 * @param object screens - the object containing all the screen sizes.
 * @returns object - the object with the matchMedia objects, keyed according to the
 *   screens paramater.
 */
const screensToQueries = (screens) => {

  // Define our basic queries object.
  let q = {};

  /**
   * Function: queryToString
   * 
   * This nested function is used 
   * 
   * @param {*} query 
   * @returns 
   */
  let queryToString = (query) => {
    let qstring = '';
    if (typeof query === 'string') {
      qstring = '(min-width: ' + query + ')';
    } else if (Array.isArray(query)) {
      let inc = 0;
      query.forEach((group) => {
        if (inc > 0) {
          qstring += ', ';
        }
        qstring += queryToString(group);
        inc += 1;
      })
    } else {
      let inc = 0;
      for (let type in query) {
        if ( inc > 0 ) {
          qstring += ' and ';
        }
        qstring += ruleToString(type, query[type]);
        inc += 1;
      }
    }
    return qstring;
  };

  /**
   * Function: ruleToString
   * 
   * This nested function is used 
   * 
   * @param {*} query 
   * @returns 
   */  
  let ruleToString = (type, rule) => {
    let ruleString = "(";
    switch (type) {
      case 'min':
        ruleString += 'min-width: ' + rule;
        break;
      case 'max':
        ruleString += 'max-width: ' + rule;
        break;
      default:
        ruleString += type + ': ' + rule;
    }
    ruleString += ")";
    return ruleString;
  }

  // Query Loop
  for ( let s in screens ) {
    q[s] = window.matchMedia(queryToString(screens[s]));
  }

  // Return the queries object, with all the matchMedia objects.
  return q;

};

// Add the object of breakpoints to Alpine.
Alpine.breakpoints = screensToQueries(screens);

// Define the magic helper to access the appropriate breakpoint from the
// breakpoints object defined above. 
Alpine.magic('breakpoint', () => mq => {
  return Alpine.breakpoints[mq].matches
});

Alpine.store('width', window.innerWidth);

window.addEventListener('resize', ($e) => {
  Alpine.store('width', window.innerWidth)
});