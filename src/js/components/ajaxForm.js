import { data } from "autoprefixer";

function cAjaxForm(ini) {

  return {
    token: ini.token,
    action: ini.action,
    formData: ini.formData,
    message: '',
    successMessage: ini.successMessage,
    loading: false,
    isSuccess: false,
    hasError: false,
    reloadOnSuccess: ini.reloadOnSuccess,

    init: function() {
      var data = this.formData;
    },

    handleResponse: function($result) {
      this.message = $result.message

      var errors = $result.errors

      var ulClass = 'ajax-error-list';
      var e = document.querySelectorAll('.' + ulClass).forEach(e => e.remove());;

      if(errors) {
        this.isSuccess = false;
        this.hasError = true;


        for (const key in errors) {

          /*
           * key = the field ID from the form that has an error
           * errors[key] = getting the value of the error that matches the key
          */

          // Form Element Errors
          var elErrors = errors[key];

          // Create unordered list
          var ul = document.createElement('ul');
          var ulId = 'ajax-error-list-' + key;
          ul.setAttribute("id", ulId)
          ul.setAttribute("class", ulClass);

          // Remove existing error ULs
          var e = document.getElementById(ulId);
          if(e !== null) e.remove();

          for(var error in elErrors) {
            var elError = elErrors[error];

            // Create list item
            var li = document.createElement('li');
            li.setAttribute("class", 'text-error')

            // Set li innerHTML to be the error
            li.innerHTML = elError;

            // Append the li to the ul
            ul.appendChild(li);
          }

           console.log(ul);

          // Form element by ID that matches the key from the error
          var form = this.$root;
          var formItem = form.querySelector('#' + key);

          // Inster error UL after the form item with the matching ID
          formItem.parentNode.insertBefore(ul, formItem.nextSibling);
        }
      } else {
        this.isSuccess = true;
        this.hasError = false;
        this.message = this.successMessage;
        // location.reload();
        this.$root.reset();
        console.log(this.successMessage);

        if(this.reloadOnSuccess) {
          setTimeout(function(){ location.reload(); }, 1000);
        }
      }
    },

    onSubmit: function() {
      this.loading = true;
      fetch(this.action, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-Token': this.token,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(this.formData),
      })
      .then(response => response.json())
      .then((data) => {
        this.handleResponse(data);
        console.log(this.formData);
      }).catch((error) => {
        console.log(error)
      }).finally(() => {
        this.loading = false;
      });
    },
  }

}

export { cAjaxForm }







// function contactForm() {
//   return {
//     formData: {
//       currentPassword: '',
//       newPassword: '',
//       userId: '{{ currentUser.id }}',
//     },
//     message: '',
//     loading: false,

//     submitData() {

//     }

//   }
// }