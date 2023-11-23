/*!
 * scripts.js
 */

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';
import focus from '@alpinejs/focus';

// Inititalize Alpine
window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.plugin(intersect);
Alpine.plugin(focus);

// Import custom directives
import './directives/x-fx.js';
import './directives/x-swipe.js';

// Import custom margin properties/methods.
import './magic/breakpoint.js';
import './magic/scrollto.js';

// Import GASP and Scroll Trigger plugin
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger.js";
import alpinejs__focus from '@alpinejs/focus';

// Register Plugin
gsap.registerPlugin(ScrollTrigger);

let jsModules = require('../../package.json').jsModules;
let modKeys = Object.keys(jsModules);
let modules = {};

if (modKeys.length > 0) {
  for (let k = 0; k < modKeys.length; k++) {

    // Define the mod parameter as they key from the modKeys array
    let mod = modKeys[k];

    // Check to see if there is an element with the appropriate x-comp attribute
    var $comp = document.querySelector('[x-comp="' + mod + '"]');

    // If there is, we can load the module.
    if ($comp) {

      // Define optional store
      if ( jsModules[mod].store ) {
        Alpine.store(mod, jsModules[mod].store);
      }

      // Define the module in the modules array
      modules[mod] = false;

      // Import the module
      import(/* webpackChunkName: "[request]" */ `./components/${mod}.js`).then((fn) => {

        // Add the data to Alpine
        Alpine.data(mod, fn[jsModules[mod].callback]);

        if (jsModules[mod].functions) {
          let fName;
          for ( let f = 0; f < jsModules[mod].functions.length; f++ ) {
            fName = jsModules[mod].functions[f];
            window[fName] = fn[fName];
          }
          Alpine.store(mod, jsModules[mod].store);
        }

        // Set the module as loaded.
        modules[mod] = true;

      });
    }

  }
}

window.randomHash = function() {
  return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
}

// ----------------------------------------------------------------------------------------[ IMAGE COMPONENT ]

Alpine.data('image', function (ini) {

  return {
    sizes: ini,

    init: function() {
      this.$root.style.opacity = 1;
    },

    getSize: function(format = 'width') {
      let width = this.$store.width;
      let sizes = false;
      for ( let query in this.sizes ) {
        if ( query != 'DEFAULT' ) {
          if (this.$breakpoint(query) ) {
            return this.sizes[query][format]
          }
        } else {
          return this.sizes[query][format];
        }
      }
      // return '';
    }
  }

});


//----------------------------------------------------------------------------------------[ HEADER COMPONENT ]

Alpine.data('header', function (ini) {

  return {

    menuOpen: false,
    menuHide: true,
    menuTimer: false,

    menuMobile: false,
    menuHeight: false,

    compressThreshold: 'mq768',

    search: false,

    sticky: ini.sticky,
    stick: false,
    stickyThreshold: 50,
    scroll: 0,
    stickyReverseHide: ini.stickyReverseHide,

    width: 0,
    headerStyle: ini.headerStyle,


    init: function () {
      this.onResize();
    },

    toggleMenu: function () {
      const $body = document.querySelector('html');
      if (this.menuOpen) {
        this.menuOpen = false;
        $body.classList.remove('overflow-y-hidden');
        this.menuTimer = setTimeout(() => {
          this.menuHide = true;
          this.menuTimer = false;
        }, 200);
      } else {
        this.menuOpen = true;
        this.menuHide = false;
        $body.classList.add('overflow-y-hidden');
      }
    },

    toggleSearch: function () {
      if (this.search) {
        this.search = false;
        this.$refs['search-window'].style.height = 0;
      } else {
        this.search = true;
        requestAnimationFrame(() => {
          this.menuTimer = setTimeout(() => {
            this.$refs['search-window'].style.height = this.$refs['search-container'].offsetHeight + 'px';
            this.$refs['search-input'].focus();
            this.menuTimer = false;
          }, 100);
        });
      }
    },

    onResize: function () {
      this.menuOpen = false;
      this.menuMobile = !this.$breakpoint(this.compressThreshold);
      this.menuHeight = this.$refs['header-bar'].offsetHeight;
    },

    headerTimeline: function () {

      var tl = gsap.timeline();

      tl.to(this.$el, {
        scrollTrigger: {
          trigger: this.$el,
          scrub: true,
          start: 'top+=30',
          end: 'start+=180',
        },
        duration: 1,
        opacity: 0,
        filter: 'blur(1px)',
        y: '-100%',
      });

      // var timing = 100;
      // var scroll = window.pageYOffset;
      // if (this.menuTimer) {
      //   return false;
      // }
      // if (this.sticky) {
      //   var scroll = window.pageYOffset;
      //   this.menuTimer = window.requestAnimationFrame(() => {
      //     let overScroll = this.stickyReverseHide ? scroll > this.scroll : true;
      //     let underScroll = this.stickyReverseHide ? (this.stick && scroll < this.scroll) : false;
      //     // let headerHeight = this.$refs['header-bar'].offsetHeight;
      //     if (!this.stick && scroll > this.stickyThreshold && overScroll) {
      //       this.menuTimer = setTimeout(() => {
      //         this.stick = true;
      //         // this.$refs['header-wrap'].style.height = headerHeight + 'px';
      //         this.compressLogo = true;
      //         this.$refs['header-bar'].classList.remove('js-out');
      //         this.menuTimer = false;
      //       }, timing);
      //     } else if ((this.stick && scroll <= this.stickyThreshold) || underScroll) {
      //       if (!this.$refs['header-bar'].classList.contains('js-out')) {
      //         this.$refs['header-bar'].classList.add('js-out');
      //         this.menuTimer = setTimeout(() => {
      //           this.stick = false;
      //           // this.$refs['header-wrap'].style.height = '';
      //           this.compressLogo = false;
      //           this.menuTimer = false;

      //         }, timing);
      //       }
      //     } else {
      //       // console.log('---- no reaching option ----');
      //       // console.log(this.stick);
      //       // console.log(scroll);
      //       // console.log(this.stickyThreshold);
      //       this.menuTimer = false;
      //     }
      //     this.scroll = scroll;
      //   });
      // }
    },

    onSkip: function () {
      setTimeout(() => {
        let $main = document.getElementById('main'),
          focusable = $main.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');

        scroll({
          top: (this.$refs['header-bar'].offsetHeight),
          behavior: "smooth"
        });
        focusable.focus();
      }, 10);
    },

    menuBarClass: function () {

      let c = '';

      if (!this.menuHide) {
        c += ' js-nav';
      }
      if (this.stick) {
        c += ' js-sticky';
      }
      return c.trim();
    },
  }
});

//------------------------------------------------------------------------------------------[ LINK HANDLING ]

/**
 * Here we find all the links in the document in order to add smooth scrolling and target="_blank"
 * functionality to them. This loop handles things outputted in the standard template. It will NOT
 * account for dynamic blocks of HTML generated by JavaScript.
 */
window.handleLinks = function (links) {
  for (var i = 0, linksLength = links.length; i < linksLength; i++) {
    if (links[i].hostname != window.location.hostname) {
      if (links[i].getAttribute('data-no-target') !== 'true' &&
        links[i].getAttribute('href').substr(0, 4) !== 'tel:' &&
        links[i].getAttribute('href').substr(0, 7) !== 'mailto:') {
        links[i].target = '_blank';
      }
    } else if (links[i].getAttribute('href').substr(0, 1) === '#') {
      if (links[i].getAttribute('href').length > 1) {
        links[i].addEventListener('click', function ($e) {
          $e.preventDefault();
          var target = $e.target.getAttribute('href');
          if (!target) {
            target = $e.target.closest('a').getAttribute('href');
          }
          window.scrollToElement(target)
        });
      }
    }
  }
}
window.handleLinks(document.links);
Alpine.directive('links', el => {
  let links = el.querySelectorAll('a[href]');
  window.handleLinks(links);
})


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


// Load AlpineJs
function loadAlpine() {
  let keys = Object.keys(modules);
  let doLoad = true;
  let delay = false;
  if ( keys.length > 0 ) {
    for ( let k = 0; k < keys.length; k++ ) {
      if ( ! modules[keys[k]] ) {
        doLoad = false;
      }
    }
  }
  if ( doLoad ) {
    Alpine.start();
  } else {
    delay = setTimeout(function(){
      loadAlpine();
    }, 50);
  }
}
loadAlpine();