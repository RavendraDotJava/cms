"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["comparisonChart-js"],{

/***/ "./src/js/components/comparisonChart.js":
/*!**********************************************!*\
  !*** ./src/js/components/comparisonChart.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cComparisonChart\": () => (/* binding */ cComparisonChart)\n/* harmony export */ });\nfunction cComparisonChart(ini) {\n  return {\n    mq: ini.mq,\n    largeLayout: true,\n    selectedOptions: ini.selectedOptions,\n    init: function init() {\n      this.onResize();\n    },\n    onChange: function onChange() {\n      var $target = this.$event.target; // The event target <select>.\n\n      var selectedOption = $target.selectedIndex; // The selected <option> from the event target.\n\n      var headerIndex = $target.dataset.index; // The index of the header where the <select> list resides.\n\n      var backgroundColor = $target.options[selectedOption].dataset.color; // The background color for the selected option\n\n      var heading = $target.closest('h3'); // The heading that contains the select options\n\n      var columns = this.$refs['container'].querySelectorAll('[data-column]'); // The columns contiaining info\n\n      var _this = this; // scoping this to be used in forEach\n\n\n      this.updateSelectedOptions(this.selectedOptions, headerIndex, selectedOption);\n      this.changeText(heading, $target.options[selectedOption].value);\n      this.changeColor(heading, backgroundColor);\n      this.checkSelectedOptions(selectedOption);\n      columns.forEach(function ($value, $i) {\n        var columnIndex = $value.dataset.column;\n\n        if (columnIndex == selectedOption) {\n          if (headerIndex == '0') {\n            $value.classList.add('order-1');\n          } else if (headerIndex == '1') {\n            $value.classList.add('order-2');\n          }\n        } else if (!_this.checkSelectedOptions(Number(columnIndex))) {\n          $value.classList.remove('order-1', 'order-2');\n        }\n      });\n    },\n    updateSelectedOptions: function updateSelectedOptions($array, $index, $newValue) {\n      $array[$index] = $newValue;\n    },\n    changeColor: function changeColor($option, $bgcolor) {\n      $option.style.background = $bgcolor;\n      $option.querySelector('span[data-arrow]').style.background = $bgcolor;\n    },\n    changeText: function changeText($heading, $text) {\n      $heading.querySelector('span[data-heading]').innerHTML = $text;\n    },\n    checkSelectedOptions: function checkSelectedOptions($option) {\n      if (this.selectedOptions.includes($option)) {\n        return true;\n      } else {\n        return false;\n      }\n    },\n    onResize: function onResize(e) {\n      this.largeLayout = this.$breakpoint(this.mq);\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/comparisonChart.js?");

/***/ })

}]);