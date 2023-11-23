"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkcraft_boilerplate"] = self["webpackChunkcraft_boilerplate"] || []).push([["modal-js"],{

/***/ "./src/js/components/modal.js":
/*!************************************!*\
  !*** ./src/js/components/modal.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"cModal\": () => (/* binding */ cModal),\n/* harmony export */   \"cModalTrigger\": () => (/* binding */ cModalTrigger)\n/* harmony export */ });\nvar cModalTrigger = function cModalTrigger($e, id, mode) {\n  $e.preventDefault(); // Define our modal store\n\n  var modal = Alpine.store('modal'); // If the modal is already transitioning, we don't want to trigger it again.\n\n  if (modal.transition) {\n    return false;\n  } // Define constants\n\n\n  var $trigger = $e.target,\n      $target = document.getElementById(id),\n      $dialog = document.getElementById('modal-component'),\n      $content = document.getElementById('modal-content'),\n      $transcript = document.getElementById('modal-transcript'); // Define variables\n\n  var modalContent,\n      modalTitle,\n      params = false; // Define paramToAtts() function for use in setting the content.\n  // If we determine that we need this on other components, we might\n  // want to move this to the global scope.\n\n  var paramToAtts = function paramToAtts(params) {\n    var atts = ' ',\n        key,\n        paramKeys = Object.keys(params);\n\n    for (var p = 0; p < paramKeys.length; p++) {\n      key = paramKeys[p];\n      atts += key + '=\"' + params[key] + '\"';\n    }\n\n    return atts;\n  }; // Define parameters\n\n\n  if ($trigger.getAttribute('data-params')) {\n    var paramJson = $trigger.getAttribute('data-params');\n    params = JSON.parse(paramJson);\n  } // Reset heading and label values in the store\n\n\n  modal.heading = false;\n  modal.label = false;\n  modal.transcript = false;\n  modal.showTranscript = false;\n  modal.bg = 'bg-transparent';\n\n  if (mode === 'video') {\n    modal.bg = 'bg-transparent';\n    var videoId = $trigger.getAttribute('data-video');\n    var platform = $trigger.getAttribute('data-platform');\n    var transcript = $trigger.getAttribute('data-transcript');\n    modalContent = '<div class=\"bg-white relative pt-ratio-video\">';\n\n    if (platform === 'vimeo') {\n      modalContent += '<iframe class=\"absolute z-10 inset-0 w-full h-full\" width=\"560\" height=\"315\" src=\"https://player.vimeo.com/video/' + videoId + '?&color=28b682&autoplay=1&title=0&portrait=0\" width=\"560\" height=\"315\" frameborder=\"0\" allow=\"autoplay; fullscreen; picture-in-picture\" allowfullscreen tabindex=\"0\"></iframe>';\n    } else {\n      modalContent += '<iframe class=\"absolute z-10 inset-0 w-full h-full\" width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/' + videoId + '?rel=1&autoplay=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen=\"\" tabindex=\"0\"></iframe>';\n    }\n\n    modalContent += '</div>';\n    modal.label = 'Video Modal';\n\n    if (transcript) {\n      var $transcriptDiv = document.getElementById(transcript);\n\n      if ($transcriptDiv) {\n        modal.transcript = true;\n        var transcriptContent = $transcriptDiv.innerHTML;\n        $transcript.innerHTML = transcriptContent;\n      }\n    }\n  } else if (mode === 'image') {\n    var src = $trigger.getAttribute('href');\n    var caption = $trigger.getAttribute('data-caption');\n    modalContent = '<figure><img src=\"' + src + '\"';\n    modalContent += paramToAtts(params);\n    modalContent += '>';\n\n    if (caption) {\n      modalContent += '<caption class=\"block p-p8 text-p24\">' + caption + '</caption>';\n    }\n\n    modalContent += '</figure>';\n    modal.label = 'Image Modal';\n  } else if (mode === 'large') {\n    modal.bg = 'bg-white max-w-7xl rounded-2xl';\n    modalContent += $target.innerHTML;\n  } else {\n    modal.bg = 'bg-white max-w-p768 rounded-2xl';\n    modalContent += $target.innerHTML;\n\n    if ($target) {\n      modalTitle = $target.getAttribute('data-title');\n    }\n  }\n\n  modal.trigger = $e.target;\n\n  if (modalTitle) {\n    modal.heading = modalTitle;\n  }\n\n  if (modalContent) {\n    $content.innerHTML = modalContent;\n    modal.content = true;\n  } // console.log(modalContent)\n  // Make it active\n\n\n  modal.show = true;\n  modal.transition = true;\n  setTimeout(function () {\n    $dialog.focus();\n    modal.transition = false;\n  }, 100);\n};\n\nvar cModal = function cModal(ini) {\n  return {\n    id: ini.id,\n    focusable: false,\n    firstElement: false,\n    lastElement: false,\n    lastFocused: false,\n    closing: false,\n    init: function init() {\n      // Remove the default hidden value from the component\n      this.$root.classList.remove('hidden');\n    },\n    activate: function activate() {\n      document.querySelector('html').classList.add('overflow-y-clip');\n    },\n    showModal: function showModal() {\n      return this.$store.modal.show;\n    },\n    showHeading: function showHeading() {\n      return this.$store.modal.heading;\n    },\n    getHeading: function getHeading() {\n      return this.$store.modal.heading;\n    },\n    getContent: function getContent() {\n      return this.$store.modal.content;\n    },\n    getLabel: function getLabel() {\n      return this.$store.modal.label;\n    },\n    modalClass: function modalClass($bg) {\n      var modalClass = Alpine.store('modal').width;\n\n      if ($bg === undefined) {\n        $bg = false;\n      }\n\n      if ($bg) {\n        modalClass += ' ' + Alpine.store('modal').bg;\n      }\n\n      return modalClass;\n    },\n    closeModal: function closeModal() {\n      if (this.$store.modal.transition) {\n        return false;\n      } // Clear the window freeze\n\n\n      document.querySelector('html').classList.remove('overflow-y-clip'); // Return focus to the element that triggered the modal\n\n      if (this.$store.modal.trigger) {\n        this.$store.modal.trigger.focus();\n      }\n\n      this.$store.modal.trigger = false;\n      this.$store.modal.transition = true; // Set the show property back to false to actually hide the modal component\n\n      this.$store.modal.show = false;\n      setTimeout(function () {\n        this.$store.modal.content = false;\n        this.$store.modal.transition = false;\n      }.bind(this), 400);\n    },\n    swapModal: function swapModal($newContent) {\n      var $content = document.getElementById('modal-content');\n      var $newContent = document.getElementById($newContent);\n\n      if (this.$store.modal.transition) {\n        return false;\n      }\n\n      this.$store.modal.transition = true; // Set the show property back to false to actually hide the modal component\n\n      this.$store.modal.show = false;\n      this.$store.modal.content = false;\n      this.modalClass();\n      $content.innerHTML = $newContent.innerHTML;\n      setTimeout(function () {\n        this.$store.modal.show = true;\n        this.$store.modal.content = true;\n        this.$store.modal.transition = false;\n      }.bind(this), 400);\n    },\n    keyPress: function keyPress($e) {\n      var KEY_ESC = 27; // console.log($e);\n\n      if ($e.keyCode === KEY_ESC) {\n        this.closeModal();\n      }\n    },\n    showTranscript: function showTranscript($e) {\n      $e.preventDefault();\n      var maxHeight = 'calc(99.9999vh - (4rem + ' + this.$refs['dialog'].offsetHeight + 'px))';\n      this.$store.modal.showTranscript = !this.$store.modal.showTranscript;\n      this.$refs['transcript'].style.maxHeight = maxHeight;\n    }\n  };\n};\n\n\n\n//# sourceURL=webpack://craft-boilerplate/./src/js/components/modal.js?");

/***/ })

}]);