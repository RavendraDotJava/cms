"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["reviewForm-js"],{

/***/ "./src/js/components/reviewForm.js":
/*!*****************************************!*\
  !*** ./src/js/components/reviewForm.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cReviewForm\": () => (/* binding */ cReviewForm)\n/* harmony export */ });\nfunction cReviewForm(ini) {\n  return {\n    showReviewForm: ini.showReviewForm,\n    guestEmail: '',\n    guestFirstName: '',\n    guestLastName: '',\n    isBrandPartner: '',\n    init: function init() {},\n    formSubmit: function formSubmit() {\n      var myForm = this.$el;\n\n      var _this = this;\n\n      myForm.addEventListener(\"freeform-ajax-success\", function (event) {\n        var response = event.response;\n\n        _this.showForm(response);\n\n        cModalTrigger(event, 'modalId-reviewForm', 'large');\n      });\n    },\n    showForm: function showForm($response) {\n      this.showReviewForm = true;\n      this.guestEmail = $response.values.email;\n      this.guestFirstName = $response.values.firstName;\n      this.guestLastName = $response.values.lastName;\n      this.isBrandPartner = $response.values.brandPartner;\n      this.setGuestInfo();\n    },\n    setGuestInfo: function setGuestInfo() {\n      var guestEmail = document.getElementById('form-input-emailHidden');\n      var guestFirstName = document.getElementById('form-input-firstNameHidden');\n      var guestLastName = document.getElementById('form-input-lastNameHidden');\n      var isBrandPartner = document.getElementById('form-input-isBrandPartner');\n      guestEmail.value = this.guestEmail;\n      guestFirstName.value = this.guestFirstName;\n      guestLastName.value = this.guestLastName;\n      isBrandPartner.value = this.isBrandPartner;\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/reviewForm.js?");

/***/ })

}]);