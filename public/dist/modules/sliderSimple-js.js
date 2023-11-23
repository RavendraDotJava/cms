"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["sliderSimple-js"],{

/***/ "./src/js/components/sliderSimple.js":
/*!*******************************************!*\
  !*** ./src/js/components/sliderSimple.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cSliderSimple\": () => (/* binding */ cSliderSimple)\n/* harmony export */ });\n/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ \"./node_modules/jquery/dist/jquery.js\");\n/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _accessible360_accessible_slick__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @accessible360/accessible-slick */ \"./node_modules/@accessible360/accessible-slick/slick/slick.js\");\n/* harmony import */ var _accessible360_accessible_slick__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_accessible360_accessible_slick__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _accessible360_accessible_slick_slick_slick_min_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @accessible360/accessible-slick/slick/slick.min.css */ \"./node_modules/@accessible360/accessible-slick/slick/slick.min.css\");\n\n\n\n\nfunction cSliderSimple(ini) {\n  return {\n    selector: ini.selector,\n    // slide: 1,\n    // totalSlides: 1,\n    // upcomingSlide: false,\n    // active: false,\n    // autoplay: ini.autoplay,\n    // transitions: [],\n    init: function init() {\n      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this.$refs['slides']).slick({\n        infinite: true,\n        slidesToShow: 1,\n        slidesToScroll: 1,\n        dots: true,\n        dotsClass: 'dots flex items-center justify-center mt-p16',\n        nextArrow: this.$refs['next'],\n        prevArrow: this.$refs['previous'],\n        swipeToSlide: true,\n        speed: 200\n      });\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/sliderSimple.js?");

/***/ })

}]);