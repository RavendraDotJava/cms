function cReviewForm(ini) {

  return {
    showReviewForm: ini.showReviewForm,
    guestEmail: '',
    guestFirstName: '',
    guestLastName: '',
    isBrandPartner: '',

    init: function () {
    },

    formSubmit: function () {
      const myForm = this.$el;
      var _this = this;

      myForm.addEventListener("freeform-ajax-success", function (event) {
        const response = event.response;
        _this.showForm(response);
        cModalTrigger(event, 'modalId-reviewForm', 'large');
      });
    },

    showForm: function($response) {
      this.showReviewForm = true;
      this.guestEmail = $response.values.email;
      this.guestFirstName = $response.values.firstName;
      this.guestLastName = $response.values.lastName;
      this.isBrandPartner = $response.values.brandPartner;
      this.setGuestInfo();
    },

    setGuestInfo: function() {
      var guestEmail = document.getElementById('form-input-emailHidden');
      var guestFirstName = document.getElementById('form-input-firstNameHidden');
      var guestLastName = document.getElementById('form-input-lastNameHidden');
      var isBrandPartner = document.getElementById('form-input-isBrandPartner');

      guestEmail.value = this.guestEmail;
      guestFirstName.value = this.guestFirstName;
      guestLastName.value = this.guestLastName;
      isBrandPartner.value = this.isBrandPartner;
    }


  }
}

export { cReviewForm }