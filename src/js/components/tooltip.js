function cTooltip(ini) {

  return {

    show: false,
    left: false,
    right: false,
    onClick: function () {

      this.onResize();
      setTimeout(() => { this.show = true; }, 10);

    },

    onResize: function () {

      var viewportOffset = this.$refs['button'].getBoundingClientRect();
      var left = viewportOffset.left;
      var right = window.innerWidth - viewportOffset.right;

      this.left = (left < 150);
      this.right = (right < 150);

    },

    setClasses: function () {
      let c = '';
      if (this.left) {
        c += ' left';
      }
      if (this.right) {
        c += ' right';
      }
      return c.trim();
    },

  }

}

export { cTooltip }