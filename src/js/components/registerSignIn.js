function cRegisterSignIn(ini) {

  return {
    signIn: ini.signIn,
    register: ini.register,
    forgotPW: ini.forgotPW,

    init: function () {
      console.log('registerSignIn init');
      console.log(ini.signIn, ini.register, ini.forgotPW);
    },


    showForm: function() {
      var target = this.$el.dataset.form;

      if(target == 'signIn') {
        this.signIn = true;
        this.register = false;
        this.forgotPW = false;
      } else if(target == 'register') {
        this.signIn = false;
        this.register = true;
        this.forgotPW = false;
      } else if(target == 'forgotPW') {
        this.signIn = false;
        this.register = false;
        this.forgotPW = true;
      }
    },

    onChange: function () {

    },
  }
}

export { cRegisterSignIn }