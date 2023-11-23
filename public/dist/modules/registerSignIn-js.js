"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["registerSignIn-js"],{

/***/ "./src/js/components/registerSignIn.js":
/*!*********************************************!*\
  !*** ./src/js/components/registerSignIn.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cRegisterSignIn\": () => (/* binding */ cRegisterSignIn)\n/* harmony export */ });\nfunction cRegisterSignIn(ini) {\n  return {\n    signIn: ini.signIn,\n    register: ini.register,\n    forgotPW: ini.forgotPW,\n    init: function init() {\n      console.log('registerSignIn init');\n      console.log(ini.signIn, ini.register, ini.forgotPW);\n    },\n    showForm: function showForm() {\n      var target = this.$el.dataset.form;\n\n      if (target == 'signIn') {\n        this.signIn = true;\n        this.register = false;\n        this.forgotPW = false;\n      } else if (target == 'register') {\n        this.signIn = false;\n        this.register = true;\n        this.forgotPW = false;\n      } else if (target == 'forgotPW') {\n        this.signIn = false;\n        this.register = false;\n        this.forgotPW = true;\n      }\n    },\n    onChange: function onChange() {}\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/registerSignIn.js?");

/***/ })

}]);