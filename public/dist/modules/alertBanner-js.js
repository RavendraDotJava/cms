"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["alertBanner-js"],{

/***/ "./src/js/components/alertBanner.js":
/*!******************************************!*\
  !*** ./src/js/components/alertBanner.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cAlertBanner\": () => (/* binding */ cAlertBanner)\n/* harmony export */ });\nfunction cAlertBanner(ini) {\n  return {\n    render: ini.render,\n    showBanner: false,\n    delay: ini.delay,\n    init: function init() {\n      this.displayBanners();\n    },\n    displayBanners: function displayBanners() {\n      var _this2 = this;\n\n      setTimeout(function () {\n        var divs = document.querySelectorAll('div[data-alert]');\n\n        if (divs.length) {\n          var _this = _this2;\n          divs.forEach(function (e, i) {\n            if (i + 1 === divs.length) {\n              var id = e.id;\n              var delay = e.dataset.delay * 1000;\n              console.log('Delay: ' + delay);\n\n              if (_this.checkCookie(id)) {\n                var element = document.getElementById(id);\n                setTimeout(function () {\n                  element.style.opacity = 1;\n                  element.style.transform = 'translate(0, 0)';\n                }, delay);\n              } else {\n                _this.showBanner = false;\n              }\n            }\n          });\n        }\n      }, 500);\n    },\n    checkCookie: function checkCookie($id) {\n      if (this.getCookie($id)) {\n        return false;\n      } else {\n        return true;\n      }\n    },\n    setCookie: function setCookie(cookieName, cookieValue, expireDays) {\n      var d = new Date();\n      d.setTime(d.getTime() + expireDays * 24 * 60 * 60 * 1000);\n      var expires = \"expires=\" + d.toUTCString();\n      document.cookie = cookieName + \"=\" + cookieValue + \";\" + expires + \";path=/\";\n      document.getElementById(cookieName).remove();\n      this.displayBanners();\n    },\n    getCookie: function getCookie(cookieName) {\n      var name = cookieName + \"=\";\n      var decodedCookie = decodeURIComponent(document.cookie);\n      var ca = decodedCookie.split(';');\n\n      for (var i = 0; i < ca.length; i++) {\n        var c = ca[i];\n\n        while (c.charAt(0) == ' ') {\n          c = c.substring(1);\n        }\n\n        if (c.indexOf(name) == 0) {\n          return c.substring(name.length, c.length);\n        }\n      }\n\n      return \"\";\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/alertBanner.js?");

/***/ })

}]);