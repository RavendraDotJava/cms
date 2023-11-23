function cAlertBanner(ini) {

  return {
    render: ini.render,
    showBanner: false,
    delay: ini.delay,

    init: function() {
      this.displayBanners();
    },

    displayBanners: function() {

      setTimeout(() => {
        var divs = document.querySelectorAll('div[data-alert]');

        if(divs.length) {
          var _this = this;

          divs.forEach(function(e, i) {
            if(i + 1 === divs.length) {
              var id = e.id;
              var delay = e.dataset.delay * 1000;

              console.log('Delay: ' + delay);

              if(_this.checkCookie(id)) {
                var element = document.getElementById(id);

                setTimeout(() => {
                  element.style.opacity = 1;
                  element.style.transform = 'translate(0, 0)';
                }, delay);

              } else {
                _this.showBanner = false;
              }
            }
          });
        }
      }, 500);
    },

    checkCookie: function ($id) {
      if(this.getCookie($id)) {
        return false;
      } else {
        return true;
      }
    },

    setCookie: function (cookieName, cookieValue, expireDays) {
      const d = new Date();
      d.setTime(d.getTime() + (expireDays*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();
      document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
      document.getElementById(cookieName).remove();
      this.displayBanners();
    },

    getCookie: function (cookieName) {
      var name = cookieName + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
  }
}

export { cAlertBanner }