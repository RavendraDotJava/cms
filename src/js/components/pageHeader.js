import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger.js";

// Register Plugin
gsap.registerPlugin(ScrollTrigger);

function cPageHeader(ini) {

  return {

    pageHeaderLoader: function() {
      this.$el.style.opacity = '0';

      setTimeout(() => {
        this.$el.style.display = 'none';
      }, 500);
    },

    gsapLine: function() {
      var tl = gsap.timeline({repeat: -1, repeatDelay: .5});

      tl.to(this.$el, {
        scaleY: 1,
        opacity: 1,
        transformOrigin: "top center",
        duration: 1.2,
      });

      tl.to(this.$el, {
        scaleY: 0,
        transformOrigin: "bottom center",
        duration: .5,
      });

      tl.play();
    },

    gsapLineContainer: function() {

      gsap.to(this.$el, {
        scrollTrigger: {
          trigger: this.$refs['pageHeaderWrap'],
          scrub: true,
          start: "-1",
          end: "+=200",
        },
        scale: 0,
      });
    },

    gsapLocation: function() {
      gsap.to(this.$el, {
        scrollTrigger: {
          trigger: this.$refs['pageHeaderWrap'],
          scrub: true,
          start: "-1",
          end: "+=50",
        },
        opacity: 0,
        filter: 'blur(4px)',
        translateX: '8rem',
      });
    },

    gsapBorderPanel: function() {

      ScrollTrigger.create({
        trigger:  this.$el,
        start: "top top",
        pin: true,
        pinSpacing: false,
      });

      gsap.from(this.$el, {
        scale: 1.2,
        duration: .8,
        filter: 'blur(10px)'
      });
    },

    gsapSeamless: function() {

      // Seamless Header
      ScrollTrigger.create({
        trigger: this.$el,
        start: "top top",
        pin: true,
        pinSpacing: false,
      });

      gsap.from(this.$el, {
        scale: 1.2,
        duration: .8,
        filter: 'blur(10px)'
      });
    },


    gsapTextLoad: function() {
      gsap.from(this.$el, {
        translateY: '3rem',
        opacity: 0,
        duration: 1,
        delay: .3,
        filter: 'blur(4px)'
      });
    },

    gsapRevealText: function() {

      gsap.to(this.$el, {

        scrollTrigger: {
          trigger: this.$refs['pageHeaderWrap'],
          scrub: true,
          start: "top",
          end: '+=50%',
          pin: true,
          pinSpacing: false,
        },
        marginTop: '6rem',
        opacity: 0,
        filter: 'blur(10px)',
      });
    },


    gsapOverlay: function() {
      gsap.to(this.$el, {
        translateY: '-6rem',
        opacity: 0,
        scrollTrigger: {
          trigger: this.$refs['bgMedia'],
          scrub: true,
          pin: true,
          pinSpacing: false,
          start: "top top",
          end: "+=80%"
        },
      });
    },

    gsapImgBg: function() {
      gsap.to(this.$el, {
        marginTop: '-20rem',
        opacity: 0,
        filter: 'blur(10px)',
        scrollTrigger: {
          trigger: this.$refs['bgMedia'],
          scrub: true,
          pin: true,
          pinSpacing: false,
          start: "top top",
          end: "+=80%"
        },
      });
    },
  }
}

export { cPageHeader }