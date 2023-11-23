import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger.js";

// Register Plugin
gsap.registerPlugin(ScrollTrigger);

function cDeepDive(ini) {

  return {
    mq: 'mq1024',
    largeScreen: false,

    init: function() {
      this.onResize();

      document.addEventListener('alpine:initialized', () => {
        this.scrollPinning();
      });

    },

    onResize: function() {
      this.largeScreen = this.$breakpoint(this.mq);
      // console.log(this.largeScreen);
    },

    scrollPinning: function() {
      var _this = this;

      var listItemsHeight = _this.$refs['listItems'].offsetHeight;

      // console.log(listItemsHeight);


      ScrollTrigger.matchMedia({
        "(min-width: 1024px)": function() {


          if(listItemsHeight > 600) {
            var master = gsap.timeline({
              scrollTrigger: {
                trigger: _this.$refs['listItems'],
                scrub: false,
                start: "start +=300px",
                end: "bottom-=400px bottom-=600px",
                pin: _this.$refs['imagePinContainer'],
                pinSpacing: false,
                // markers: true,
                anticipatePin: true,
                toggleActions: "play none play reverse",
              },
            });

            master
          }
        }
      });
    },

    images: function() {

      var _this = this;

      ScrollTrigger.matchMedia({
        "(min-width: 1024px)": function() {

          var tl = gsap.timeline({
            scrollTrigger: {
              trigger: _this.$refs['listItems'],
              scrub: false,
              start: "start +=300px",
              end: "+=80%",
              pinSpacing: false,
              // markers: true,
              toggleActions: "play none play reverse",
            },
          });

          tl.from(_this.$refs['fgImage'], {
            opacity: 0,
            filter: 'blur(10px)',
            duration: .2,
            scale: '.9',
          });

          tl.from(_this.$refs['bgImage'], {
            opacity: 0,
            filter: 'blur(10px)',
            duration: .2,
            scale: '1.1',
          }, "<");

          tl.from(_this.$refs['radiantCircles'], {
            scale: '.1',
            opacity: 0,
            filter: 'blur(10px)',
            duration: .6,
          }, "<");

          return tl;

      }});
    },

    parallax: function() {

      var tl = gsap.timeline();

      tl.to(this.$el, {
        scrollTrigger: {
          scrub: true,
          trigger: this.$refs['container'],
          // markers: true,
        },
        y: (i, target) => -this.$refs['listItems'].offsetHeight * target.dataset.speed,
        rotate: '-40deg',
      });

      return tl;
    },
  }
}

export { cDeepDive }