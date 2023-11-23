function cCountryCode(ini) {

  return {
    countryCode: ini.countryCode,

    init: function ($e) {
      this.countryCode = this.$refs['countryCode'].value;

      // console.log('Country Code script init');
      // console.log(this.countryCode);

      this.updateAdministrativeArea();
    },

    countryChange: function ($e) {
      console.log('Country Code script onChange');
      this.updateAdministrativeArea();
    },

    updateAdministrativeArea: function ($e) {
      this.countryCode = this.$refs['countryCode'].value;
      console.log('countryCode=' + this.countryCode);
    },

  }

}

export { cCountryCode }