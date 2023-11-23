"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["previewImage-js"],{

/***/ "./src/js/components/previewImage.js":
/*!*******************************************!*\
  !*** ./src/js/components/previewImage.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cPreviewImage\": () => (/* binding */ cPreviewImage)\n/* harmony export */ });\nfunction cPreviewImage(ini) {\n  return {\n    imageUploadId: ini.imageUploadId,\n    imagePreviewId: ini.imagePreviewId,\n    files: null,\n    init: function init() {// console.log('test');\n    },\n    onClick: function onClick() {\n      var _this = this;\n\n      this.getImgUrl(this.$el.value, function (imgBlob) {\n        var fileInput = document.getElementById(_this.imageUploadId);\n        var dataTransfer = new DataTransfer();\n        var file = new File([imgBlob], _this.$el.id + '.jpg', {\n          type: \"image/jpeg\"\n        });\n        dataTransfer.items.add(file);\n        fileInput.files = dataTransfer.files;\n      });\n    },\n    getImgUrl: function getImgUrl(url, callback) {\n      var xhr = new XMLHttpRequest();\n\n      xhr.onload = function () {\n        callback(xhr.response);\n      };\n\n      xhr.open('GET', url);\n      xhr.responseType = 'blob';\n      xhr.send();\n    },\n    showPreview: function showPreview() {\n      var oFReader = new FileReader();\n      var image = document.getElementById(this.imagePreviewId);\n      document.getElementById('reviewPhotoUpload').checked = true;\n      oFReader.readAsDataURL(document.getElementById(this.imageUploadId).files[0]);\n\n      oFReader.onload = function (oFREvent) {\n        image.src = oFREvent.target.result;\n      };\n    }\n  };\n}\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/previewImage.js?");

/***/ })

}]);