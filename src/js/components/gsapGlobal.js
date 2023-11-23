import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger.js";

// Register Plugin
gsap.registerPlugin(ScrollTrigger);

function cGsapGlobal(ini) {

  return {

    init: function() {
      // console.log('init');
    },

    gsapScaleUp: function($duration=.6, $delay=0) {

      gsap.from(this.$el, {
        scrollTrigger: {
          trigger: this.$refs['scrollTrigger'],
          start: "top +=50%",
          end: "bottom +=50%",
        },
        scale: .2,
        transformOrigin: "center center",
        // ease: "none",
        opacity: 0,
        filter: 'blur(5px)',
        duration: $duration,
        delay: $delay,
        translateY: '3rem',
      });
    },

    gsapFadeIn: function($duration=.5, $delay=0, $start='top +=88%', $end='bottom +=88%', $distance='1rem') {
      gsap.from(this.$el, {
        scrollTrigger: {
          trigger: this.$refs['scrollTrigger'],
          start: $start,
          end: $end,
          toggleActions: "play play play reverse",
          // markers: true
        },
        opacity: 0,
        filter: 'blur(4px)',
        translateY: $distance,
        duration: $duration,
        delay: $delay,
      });
    },


    gsapBlurIn: function($duration=1, $delay=0) {
      gsap.from(this.$el, {
        scrollTrigger: {
          trigger: this.$refs['scrollTrigger'],
          start: "top +=80%",
          end: "top +=80%",
        },
        filter: 'blur(4px)',
        duration: $duration,
        delay: $delay,
      });
    },


    radiantCircles: function() {
      var tl = gsap.timeline();

      tl.to(this.$el, {
        yoyo: true,
        repeat: -1,
        scale: .9,
        duration: 3,
        ease: "power1.inOut"
      });
    },

  }
}

export { cGsapGlobal }