"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["paymentForm-js"],{

/***/ "./src/js/components/paymentForm.js":
/*!******************************************!*\
  !*** ./src/js/components/paymentForm.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cPaymentForm\": () => (/* binding */ cPaymentForm)\n/* harmony export */ });\nfunction cPaymentForm(ini) {\n  return {\n    paymentFormFirstName: '',\n    paymentFormLastName: '',\n    paymentFormNumber: '',\n    paymentFormCvv: '',\n    paymentFormExpMonth: '',\n    paymentFormExpYear: '',\n    init: function init() {\n      console.log('payment form init function');\n    },\n    onSubmit: function onSubmit() {\n      var paymentForm = document.forms['paymentForm'];\n      var subscriptionForm = document.getElementsByName('subscriptionForm');\n      console.log('on submit function');\n      console.log(paymentForm);\n\n      if (subscriptionForm) {\n        subscriptionForm.forEach(function (element) {\n          element.submit();\n        });\n      }\n\n      paymentForm.submit(); // if(subscriptionForm) {\n      //   subscriptionForm.submit();\n      // }\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/paymentForm.js?");

/***/ })

}]);