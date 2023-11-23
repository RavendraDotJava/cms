import $ from "jquery";
import "@accessible360/accessible-slick";
import "@accessible360/accessible-slick/slick/slick.min.css";

function cSliderSimple(ini) {

  return {
    selector: ini.selector,
    // slide: 1,
    // totalSlides: 1,
    // upcomingSlide: false,
    // active: false,
    // autoplay: ini.autoplay,
    // transitions: [],

    init: function() {

      $(this.$refs['slides']).slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        dotsClass: 'dots flex items-center justify-center mt-p16',
        nextArrow: this.$refs['next'],
        prevArrow: this.$refs['previous'],
        swipeToSlide: true,
        speed: 200,
      });
    },
  }
}

export { cSliderSimple }