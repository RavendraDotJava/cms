"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["card-js"],{

/***/ "./src/js/components/card.js":
/*!***********************************!*\
  !*** ./src/js/components/card.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cCard\": () => (/* binding */ cCard)\n/* harmony export */ });\nfunction cCard(ini) {\n  return {\n    touched: false,\n    onClick: function onClick($e) {\n      var href = this.$refs['link'].getAttribute('href');\n      var blank = this.$refs['link'].getAttribute('target') === '_blank';\n      var delay = this.touched ? 300 : 1;\n\n      if (href) {\n        setTimeout(function () {\n          if ($e.ctrlKey || $e.metaKey || blank) {\n            window.open(href, '_blank').focus();\n          } else {\n            window.location = href;\n          }\n        }, delay);\n      }\n    },\n    onTouch: function onTouch($e) {\n      this.touched = true;\n    },\n    onKey: function onKey($e) {\n      if ($e.type === 'keypress') {\n        if ($e.keyCode === 13) {\n          this.onClick();\n        }\n      }\n    },\n    buttonClick: function buttonClick($e) {\n      $e.preventDefault();\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/card.js?");

/***/ })

}]);