/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["ajaxForm-js"],{

/***/ "./src/js/components/ajaxForm.js":
/*!***************************************!*\
  !*** ./src/js/components/ajaxForm.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cAjaxForm\": () => (/* binding */ cAjaxForm)\n/* harmony export */ });\n/* harmony import */ var autoprefixer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! autoprefixer */ \"./node_modules/autoprefixer/lib/autoprefixer.js\");\n/* harmony import */ var autoprefixer__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(autoprefixer__WEBPACK_IMPORTED_MODULE_0__);\n\n\nfunction cAjaxForm(ini) {\n  return {\n    token: ini.token,\n    action: ini.action,\n    formData: ini.formData,\n    message: '',\n    successMessage: ini.successMessage,\n    loading: false,\n    isSuccess: false,\n    hasError: false,\n    reloadOnSuccess: ini.reloadOnSuccess,\n    init: function init() {\n      var data = this.formData;\n    },\n    handleResponse: function handleResponse($result) {\n      this.message = $result.message;\n      var errors = $result.errors;\n      var ulClass = 'ajax-error-list';\n      var e = document.querySelectorAll('.' + ulClass).forEach(function (e) {\n        return e.remove();\n      });\n      ;\n\n      if (errors) {\n        this.isSuccess = false;\n        this.hasError = true;\n\n        for (var key in errors) {\n          /*\n           * key = the field ID from the form that has an error\n           * errors[key] = getting the value of the error that matches the key\n          */\n          // Form Element Errors\n          var elErrors = errors[key]; // Create unordered list\n\n          var ul = document.createElement('ul');\n          var ulId = 'ajax-error-list-' + key;\n          ul.setAttribute(\"id\", ulId);\n          ul.setAttribute(\"class\", ulClass); // Remove existing error ULs\n\n          var e = document.getElementById(ulId);\n          if (e !== null) e.remove();\n\n          for (var error in elErrors) {\n            var elError = elErrors[error]; // Create list item\n\n            var li = document.createElement('li');\n            li.setAttribute(\"class\", 'text-error'); // Set li innerHTML to be the error\n\n            li.innerHTML = elError; // Append the li to the ul\n\n            ul.appendChild(li);\n          }\n\n          console.log(ul); // Form element by ID that matches the key from the error\n\n          var form = this.$root;\n          var formItem = form.querySelector('#' + key); // Inster error UL after the form item with the matching ID\n\n          formItem.parentNode.insertBefore(ul, formItem.nextSibling);\n        }\n      } else {\n        this.isSuccess = true;\n        this.hasError = false;\n        this.message = this.successMessage; // location.reload();\n\n        this.$root.reset();\n        console.log(this.successMessage);\n\n        if (this.reloadOnSuccess) {\n          setTimeout(function () {\n            location.reload();\n          }, 1000);\n        }\n      }\n    },\n    onSubmit: function onSubmit() {\n      var _this = this;\n\n      this.loading = true;\n      fetch(this.action, {\n        method: 'POST',\n        headers: {\n          'Accept': 'application/json',\n          'Content-Type': 'application/json',\n          'X-CSRF-Token': this.token,\n          'X-Requested-With': 'XMLHttpRequest'\n        },\n        body: JSON.stringify(this.formData)\n      }).then(function (response) {\n        return response.json();\n      }).then(function (data) {\n        _this.handleResponse(data);\n\n        console.log(_this.formData);\n      }).catch(function (error) {\n        console.log(error);\n      }).finally(function () {\n        _this.loading = false;\n      });\n    }\n  };\n}\n\n // function contactForm() {\n//   return {\n//     formData: {\n//       currentPassword: '',\n//       newPassword: '',\n//       userId: '{{ currentUser.id }}',\n//     },\n//     message: '',\n//     loading: false,\n//     submitData() {\n//     }\n//   }\n// }\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/ajaxForm.js?");

/***/ }),

/***/ "?3465":
/*!**********************!*\
  !*** path (ignored) ***!
  \**********************/
/***/ (() => {

eval("/* (ignored) */\n\n//# sourceURL=webpack://craft-boilerplate/path_(ignored)?");

/***/ }),

/***/ "?5580":
/*!**************************************!*\
  !*** ./terminal-highlight (ignored) ***!
  \**************************************/
/***/ (() => {

eval("/* (ignored) */\n\n//# sourceURL=webpack://craft-boilerplate/./terminal-highlight_(ignored)?");

/***/ }),

/***/ "?03fb":
/*!********************!*\
  !*** fs (ignored) ***!
  \********************/
/***/ (() => {

eval("/* (ignored) */\n\n//# sourceURL=webpack://craft-boilerplate/fs_(ignored)?");

/***/ }),

/***/ "?6197":
/*!**********************!*\
  !*** path (ignored) ***!
  \**********************/
/***/ (() => {

eval("/* (ignored) */\n\n//# sourceURL=webpack://craft-boilerplate/path_(ignored)?");

/***/ }),

/***/ "?b8cb":
/*!*******************************!*\
  !*** source-map-js (ignored) ***!
  \*******************************/
/***/ (() => {

eval("/* (ignored) */\n\n//# sourceURL=webpack://craft-boilerplate/source-map-js_(ignored)?");

/***/ }),

/***/ "?c717":
/*!*********************!*\
  !*** url (ignored) ***!
  \*********************/
/***/ (() => {

eval("/* (ignored) */\n\n//# sourceURL=webpack://craft-boilerplate/url_(ignored)?");

/***/ })

}]);