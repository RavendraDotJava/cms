function cCard(ini) {

  return {

    touched: false,

    onClick: function ($e) {
      var href = this.$refs['link'].getAttribute('href');
      var blank = (this.$refs['link'].getAttribute('target') === '_blank');
      var delay = this.touched ? 300 : 1;
      if (href) {
        setTimeout(function () {
          if ($e.ctrlKey || $e.metaKey || blank) {
            window.open(href, '_blank').focus();
          } else {
            window.location = href;
          }
        }, delay);
      }
    },

    onTouch: function ($e) {
      this.touched = true;
    },

    onKey: function ($e) {
      if ($e.type === 'keypress') {
        if ($e.keyCode === 13) {
          this.onClick();
        }
      }
    },

    buttonClick: function ($e) {
      $e.preventDefault();
    }

  }

}

export { cCard }