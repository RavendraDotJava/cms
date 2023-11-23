"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["tooltip-js"],{

/***/ "./src/js/components/tooltip.js":
/*!**************************************!*\
  !*** ./src/js/components/tooltip.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cTooltip\": () => (/* binding */ cTooltip)\n/* harmony export */ });\nfunction cTooltip(ini) {\n  return {\n    show: false,\n    left: false,\n    right: false,\n    onClick: function onClick() {\n      var _this = this;\n\n      this.onResize();\n      setTimeout(function () {\n        _this.show = true;\n      }, 10);\n    },\n    onResize: function onResize() {\n      var viewportOffset = this.$refs['button'].getBoundingClientRect();\n      var left = viewportOffset.left;\n      var right = window.innerWidth - viewportOffset.right;\n      this.left = left < 150;\n      this.right = right < 150;\n    },\n    setClasses: function setClasses() {\n      var c = '';\n\n      if (this.left) {\n        c += ' left';\n      }\n\n      if (this.right) {\n        c += ' right';\n      }\n\n      return c.trim();\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/tooltip.js?");

/***/ })

}]);