"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["flashNotice-js"],{

/***/ "./src/js/components/flashNotice.js":
/*!******************************************!*\
  !*** ./src/js/components/flashNotice.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cFlashNotice\": () => (/* binding */ cFlashNotice)\n/* harmony export */ });\nfunction cFlashNotice(ini) {\n  return {\n    showError: ini.showError,\n    showNotice: ini.showNotice,\n    timer: 9000,\n    init: function init() {\n      var _this = this;\n\n      if (this.showNotice) {\n        setTimeout(function () {\n          _this.showNotice = false;\n        }, this.timer);\n      }\n\n      if (this.showError) {\n        setTimeout(function () {\n          _this.showError = false;\n        }, this.timer);\n      }\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/flashNotice.js?");

/***/ })

}]);