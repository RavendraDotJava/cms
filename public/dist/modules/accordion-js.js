"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["accordion-js"],{

/***/ "./src/js/components/accordion.js":
/*!****************************************!*\
  !*** ./src/js/components/accordion.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cAccordion\": () => (/* binding */ cAccordion)\n/* harmony export */ });\nfunction cAccordion(ini) {\n  return {\n    $btn: false,\n    $answer: false,\n    $window: false,\n    active: false,\n    response: false,\n    respond: ini.mq && ini.respond ? ini.respond : false,\n    mq: ini.mq && ini.respond ? ini.mq : '',\n    init: function init() {\n      this.$btn = this.$refs['btn'];\n      this.$answer = this.$refs['answer'];\n      this.$window = this.$refs['window'];\n      this.onResize();\n      this.$window.classList.remove('hidden');\n    },\n    toggle: function toggle() {\n      this.active = !this.active;\n    },\n    isActive: function isActive() {\n      var respond = this.response;\n\n      if (this.respond === 'hide' && !respond) {\n        return true;\n      } else if (this.respond === 'show' && respond) {\n        return true;\n      }\n\n      return this.active ? true : false;\n    },\n    isExpanded: function isExpanded() {\n      return this.isActive() ? \"true\" : \"false\";\n    },\n    isHidden: function isHidden() {\n      return this.isActive() ? \"false\" : \"true\";\n    },\n    flipChevron: function flipChevron() {\n      return this.isActive() ? 'js-active' : '';\n    },\n    showChevron: function showChevron() {\n      var respond = this.response;\n\n      if (this.respond === 'hide' && !respond) {\n        return false;\n      } else if (this.respond === 'show' && respond) {\n        return false;\n      }\n\n      return true;\n    },\n    onResize: function onResize() {\n      if (this.mq) {\n        this.response = this.$breakpoint(this.mq);\n      }\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/accordion.js?");

/***/ })

}]);