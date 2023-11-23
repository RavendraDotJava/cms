function cTabs(ini) {

  return {

    render: false,
    active: (ini.default) ? ini.default : 1,
    default: (ini.default) ? ini.default : 1,
    total: ini.total,

    response: false,
    respond: (ini.mq && ini.respond) ? ini.respond : false,
    mq: (ini.mq && ini.respond) ? ini.mq : '',

    init: function () {

      console.log(this.mq);

      this.onResize();

      // Set initial ARIA states for accessible control
      for (var x = 1; x <= this.total; x++) {
        if (x === this.default) {
          this.$refs['tab-' + x].setAttribute('aria-selected', true);
          this.$refs['panel-' + x].setAttribute('aria-hidden', false);
        } else {
          this.$refs['tab-' + x].setAttribute('aria-selected', false);
          this.$refs['panel-' + x].setAttribute('aria-hidden', true);
        }
      }

    },

    isTabbed: function() {
      return this.render;
    },

    showTab: function (index) {

      let render = this.render;
      if (render) {
        if (this.active === Number(index)) {
          this.$refs['panel-' + index].setAttribute('aria-hidden', false);
          return true;
        } else {
          this.$refs['panel-' + index].setAttribute('aria-hidden', true);
          return false;
        }
      } else {
        this.$refs['panel-' + index].setAttribute('aria-hidden', false);
        return true;
      }

    },

    tabClick: function (e) {

      // Get the button itself
      var $btn = e.target;
      // Quick check in case there are nested elements in the tab, such as an icon.
      if (!$btn.classList.contains('.c-tab')) {
        $btn = $btn.closest('.c-tab');
      }

      // Set the index.
      var index = Number($btn.getAttribute('data-index')),
        height = this.$refs['panel-' + this.active].offsetHeight;

      this.$refs['window'].style.height = height + 'px';

      this.$refs['tab-' + this.active].setAttribute('aria-selected', false);
      this.$refs['panel-' + this.active].setAttribute('aria-hidden', true);

      this.active = index;
      this.$refs['tab-' + index].setAttribute('aria-selected', true);
      this.$refs['panel-' + index].setAttribute('aria-hidden', false);

      var _this = this;
      setTimeout(function () {
        height = _this.$refs['panel-' + index].offsetHeight;
        _this.$refs['window'].style.height = height + 'px';
      }, 300);

    },

    onRender: function() {
      let respond = this.response;
      if (this.respond === 'hide' && !respond) {
        this.render = false;
      } else if (this.respond === 'show' && respond) {
        this.render = false;
      } else {
        this.render = true;
      }
    },

    onResize: function (e) {
      if (this.mq) {
        this.response = this.$breakpoint(this.mq);
      }      
      this.onRender();
      if (this.render) {
        var height = this.$refs['panel-' + this.active].offsetHeight;
        this.$refs['window'].style.height = height + 'px';
      } else {
        this.$refs['window'].style.height = '';
      }
    },

  }

}

export { cTabs }