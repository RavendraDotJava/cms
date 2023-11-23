function cAddress(ini) {

  return {
    billingSame: ini.billingSame,
    newAddress: ini.newAddress,

    init: function ($e) {
      this.billingSame = this.$refs['billingSame'].value;
      this.toggleBillingInputDisabledAttr('billingAddress');
    },


    billingSameAsShippingChange: function ($e) {
      this.billingSame = ! this.billingSame;
      this.toggleBillingInputDisabledAttr('billingAddress');
      this.$refs['billingSame'].value = this.billingSame;
    },

    // Disables all input fields on billingAddress form
    toggleBillingInputDisabledAttr: function ($e) {
      for (let input of this.$refs[$e].querySelectorAll('input, select')) {
        if (this.billingSame) {
          input.setAttribute('disabled', '');
        } else {
          input.removeAttribute('disabled');
        }
      }
    },

    toggleShippingInputDisabledAttr: function ($e) {
      var addressFieldset = this.$event.target.closest('.js-address-fieldset');
      var addressFields = addressFieldset.querySelector('.js-new-address');

      for (let input of addressFields.querySelectorAll('input, select')) {
        if (this.newAddress == true) {
          input.removeAttribute('disabled');
          input.value = '';
          console.log('test')
        } else if (this.newAddress == false) {
          input.setAttribute('disabled', '');
        }
      }
    },

    onSelect: function ($e) {
      var _this = this.$event.target;

      // this.newShippingAddress = ! this.newShippingAddress;
      this.newAddress = false;

      console.log("New Address?: " + this.newAddress);
      this.toggleShippingInputDisabledAttr();
    },

    onSelectCreateNewAddress: function ($e) {
      var _this = this.$event.target;
      this.newAddress = true;
      console.log(this.newAddress);
      this.toggleShippingInputDisabledAttr();
    },
  }
}

export { cAddress }