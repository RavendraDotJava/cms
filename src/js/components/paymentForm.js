function cPaymentForm(ini) {

  return {
    paymentFormFirstName: '',
    paymentFormLastName: '',
    paymentFormNumber: '',
    paymentFormCvv: '',
    paymentFormExpMonth: '',
    paymentFormExpYear: '',

    init: function () {
      console.log('payment form init function');
    },

    onSubmit: function () {
      const paymentForm = document.forms['paymentForm'];
      const subscriptionForm = document.getElementsByName('subscriptionForm');

      console.log('on submit function');
      console.log(paymentForm);

      if(subscriptionForm) {
        subscriptionForm.forEach(element => {
          element.submit();
        });
      }

      paymentForm.submit();

        // if(subscriptionForm) {
        //   subscriptionForm.submit();
        // }
    },
  }
}

export { cPaymentForm }