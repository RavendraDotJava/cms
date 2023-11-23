function cSlider(ini) {

  return {

    slide: 1,
    totalSlides: 1,
    upcomingSlide: false,
    active: false,

    autoplay: ini.autoplay,
    speed: ini.speed,
    paused: false,
    modalPaused: false,

    timeout: false,
    timer: false,
    transitions: [],

    init: function() {

      var $slide = this.$refs['slide-1'];
      this.transitions.push($slide.getAttribute('x-transition:enter'));
      this.transitions.push($slide.getAttribute('x-transition:enter-start'));
      this.transitions.push($slide.getAttribute('x-transition:enter-end'));
      this.transitions.push($slide.getAttribute('x-transition:leave'));
      this.transitions.push($slide.getAttribute('x-transition:leave-start'));
      this.transitions.push($slide.getAttribute('x-transition:leave-end'));

      var count = this.$refs['window'].querySelectorAll('li').length;
      this.totalSlides = count;

      this.$refs['timer'].style.animationDuration = ((this.speed*1000) - 110) + 'ms';
      this.timer = true;

      if ( this.autoplay ) {
        this.setSliderTimeout();
      }

    },

    showSlide: function(index) {
      return ( this.slide === index );
    },

    togglePause: function() {
      if ( this.paused ) {
        this.paused = false;
      } else {
        this.paused = true;
      }
    },

    toggleModalPause: function () {
      if (this.modalPaused) {
        this.modalPaused = false;
      } else {
        this.modalPaused = true;
      }
    },

    isPaused: function() {
      if ( this.paused || this.modalPaused ) {
        clearTimeout(this.timeout);
        this.timeout = 'paused';
        return true;
      } else {
        if (this.timeout === 'paused' ) {
          this.setSliderTimeout();
        }
      }
    },

    isModal: function () {
      if ( this.$store.modal ) {
        if (this.$store.modal.show !== this.modalPaused ) {
          this.toggleModalPause();
        }
      } else {
        return false;
      }
    },

    prevSlide: function() {
      if ( this.active ) { return false; }
      this.upcomingSlide = ((this.slide - 1) < 1 ) ? this.totalSlides : this.slide - 1;
      this.changeSlide();
    },

    nextSlide: function() {
      if (this.active) { return false; }
      this.upcomingSlide = ((this.slide + 1) > this.totalSlides) ? 1 : this.slide + 1;
      this.changeSlide();
    },

    changeSlide: function() {
      var $slide = this.$refs['slide-' + this.slide],
          $upcoming = this.$refs['slide-' + this.upcomingSlide],
          $window = this.$refs['window'],
          height = $slide.offsetHeight,

          _this = this;

      $window.style.height = height + 'px';

      this.slide = this.upcomingSlide;
      this.upcomingSlide = false;
      this.active = true;
      this.timer = false;
      void this.$refs['timer'].offsetWidth;

      clearTimeout(this.timeout);
      this.timeout = false;

      setTimeout(function(){
        var height = $upcoming.offsetHeight;
        _this.timer = true;
        if ( _this.autoplay ) {
          _this.setSliderTimeout();
        }
        // $window.style.height = height + 'px';

        setTimeout(function() {
          $window.style.height = '';
          _this.active = false;
          for ( var t = 0; t < _this.transitions.length; t++ ) {
            $slide.classList.remove(_this.transitions[t]);
            $upcoming.classList.remove(_this.transitions[t])
          }
        }, 1100);
      },10);

    },

    setSliderTimeout: function () {

      var _this = this;

      clearTimeout(this.timeout);
      this.timeout = false;

      if (this.paused || this.modalPaused) {
        return false;
      }

      this.timeout = setTimeout(function () {

        if ( ! _this.isPaused() ) {
          _this.nextSlide();
          _this.setSliderTimeout();
        }

      }, (this.speed * 1000));

    },

  }

}

export { cSlider }