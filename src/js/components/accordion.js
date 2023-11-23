function cAccordion(ini) {

  return {

    $btn: false,
    $answer: false,
    $window: false,

    active: false,
    
    response: false,
    respond: (ini.mq && ini.respond) ? ini.respond : false,
    mq: (ini.mq && ini.respond) ? ini.mq : '',

    init: function () {
      this.$btn = this.$refs['btn'];
      this.$answer = this.$refs['answer'];
      this.$window = this.$refs['window'];
      this.onResize();

      this.$window.classList.remove('hidden');
    },

    toggle: function () {
      this.active = !this.active;
    },

    isActive: function() {
      let respond = this.response;
      if ( this.respond === 'hide' && ! respond ) {
        return true;
      } else if ( this.respond === 'show' && respond ) {
        return true;
      }
      return (this.active) ? true : false;      
    },

    isExpanded: function () {
      return (this.isActive()) ? "true" : "false";
    },

    isHidden: function () {
      return (this.isActive()) ? "false" : "true";
    },

    flipChevron: function () {
      return (this.isActive()) ? 'js-active' : '';
    },

    showChevron: function () {
      let respond = this.response;
      if (this.respond === 'hide' && !respond) {
        return false;
      } else if (this.respond === 'show' && respond) {
        return false;
      }
      return true;
    },    

    onResize: function () {
      if ( this.mq ) {
        this.response = this.$breakpoint(this.mq);
      }
    }

  }

}

export { cAccordion }