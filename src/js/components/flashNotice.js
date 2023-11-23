function cFlashNotice(ini) {

  return {
    showError: ini.showError,
    showNotice: ini.showNotice,
    timer: 9000,

    init: function () {
      if(this.showNotice) {
        setTimeout(() => {
          this.showNotice = false;
        }, this.timer)
      }

      if(this.showError) {
        setTimeout(() => {
          this.showError = false;
        }, this.timer)
      }
    },
  }
}

export { cFlashNotice }