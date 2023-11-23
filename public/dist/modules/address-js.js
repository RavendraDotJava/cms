"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["address-js"],{

/***/ "./src/js/components/address.js":
/*!**************************************!*\
  !*** ./src/js/components/address.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cAddress\": () => (/* binding */ cAddress)\n/* harmony export */ });\nfunction _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== \"undefined\" && o[Symbol.iterator] || o[\"@@iterator\"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === \"number\") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError(\"Invalid attempt to iterate non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\nfunction cAddress(ini) {\n  return {\n    billingSame: ini.billingSame,\n    newAddress: ini.newAddress,\n    init: function init($e) {\n      this.billingSame = this.$refs['billingSame'].value;\n      this.toggleBillingInputDisabledAttr('billingAddress');\n    },\n    billingSameAsShippingChange: function billingSameAsShippingChange($e) {\n      this.billingSame = !this.billingSame;\n      this.toggleBillingInputDisabledAttr('billingAddress');\n      this.$refs['billingSame'].value = this.billingSame;\n    },\n    // Disables all input fields on billingAddress form\n    toggleBillingInputDisabledAttr: function toggleBillingInputDisabledAttr($e) {\n      var _iterator = _createForOfIteratorHelper(this.$refs[$e].querySelectorAll('input, select')),\n          _step;\n\n      try {\n        for (_iterator.s(); !(_step = _iterator.n()).done;) {\n          var input = _step.value;\n\n          if (this.billingSame) {\n            input.setAttribute('disabled', '');\n          } else {\n            input.removeAttribute('disabled');\n          }\n        }\n      } catch (err) {\n        _iterator.e(err);\n      } finally {\n        _iterator.f();\n      }\n    },\n    toggleShippingInputDisabledAttr: function toggleShippingInputDisabledAttr($e) {\n      var addressFieldset = this.$event.target.closest('.js-address-fieldset');\n      var addressFields = addressFieldset.querySelector('.js-new-address');\n\n      var _iterator2 = _createForOfIteratorHelper(addressFields.querySelectorAll('input, select')),\n          _step2;\n\n      try {\n        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {\n          var input = _step2.value;\n\n          if (this.newAddress == true) {\n            input.removeAttribute('disabled');\n            input.value = '';\n            console.log('test');\n          } else if (this.newAddress == false) {\n            input.setAttribute('disabled', '');\n          }\n        }\n      } catch (err) {\n        _iterator2.e(err);\n      } finally {\n        _iterator2.f();\n      }\n    },\n    onSelect: function onSelect($e) {\n      var _this = this.$event.target; // this.newShippingAddress = ! this.newShippingAddress;\n\n      this.newAddress = false;\n      console.log(\"New Address?: \" + this.newAddress);\n      this.toggleShippingInputDisabledAttr();\n    },\n    onSelectCreateNewAddress: function onSelectCreateNewAddress($e) {\n      var _this = this.$event.target;\n      this.newAddress = true;\n      console.log(this.newAddress);\n      this.toggleShippingInputDisabledAttr();\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/address.js?");

/***/ })

}]);