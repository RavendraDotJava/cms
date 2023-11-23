var cModalTrigger = function($e, id, mode) {

  $e.preventDefault();

  // Define our modal store
  const modal = Alpine.store('modal');

  // If the modal is already transitioning, we don't want to trigger it again.
  if ( modal.transition ) { return false; }

  // Define constants
  const
    $trigger = $e.target,
    $target = document.getElementById(id),
    $dialog = document.getElementById('modal-component'),
    $content = document.getElementById('modal-content'),
    $transcript = document.getElementById('modal-transcript');

  // Define variables
  let
    modalContent, modalTitle,
    params = false;

  // Define paramToAtts() function for use in setting the content.
  // If we determine that we need this on other components, we might
  // want to move this to the global scope.
  var paramToAtts = function(params) {
    let atts = ' ',
        key,
        paramKeys = Object.keys(params);
    for ( let p = 0; p < paramKeys.length; p++ ) {
      key = paramKeys[p];
      atts += key + '="' + params[key] + '"';
    }
    return atts;
  };

  // Define parameters
  if ( $trigger.getAttribute('data-params') ) {
    let paramJson = $trigger.getAttribute('data-params');
    params = JSON.parse(paramJson);

  }


  // Reset heading and label values in the store
  modal.heading = false;
  modal.label = false;
  modal.transcript = false;
  modal.showTranscript = false;
  modal.bg = 'bg-transparent';

  if ( mode === 'video' ) {

    modal.bg = 'bg-transparent';

    let videoId = $trigger.getAttribute('data-video');
    let platform = $trigger.getAttribute('data-platform');
    let transcript = $trigger.getAttribute('data-transcript');
    modalContent = '<div class="bg-white relative pt-ratio-video">';
    if (platform === 'vimeo') {
      modalContent += '<iframe class="absolute z-10 inset-0 w-full h-full" width="560" height="315" src="https://player.vimeo.com/video/' + videoId + '?&color=28b682&autoplay=1&title=0&portrait=0" width="560" height="315" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen tabindex="0"></iframe>';
    } else {
      modalContent += '<iframe class="absolute z-10 inset-0 w-full h-full" width="560" height="315" src="https://www.youtube.com/embed/' + videoId + '?rel=1&autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" tabindex="0"></iframe>';
    }
    modalContent += '</div>';

    modal.label = 'Video Modal';

    if (transcript) {
      let $transcriptDiv = document.getElementById(transcript);
      if ($transcriptDiv) {
        modal.transcript = true;
        let transcriptContent = $transcriptDiv.innerHTML;
        $transcript.innerHTML = transcriptContent;
      }
    }


  } else if ( mode === 'image' ) {

    let src = $trigger.getAttribute('href');
    let caption = $trigger.getAttribute('data-caption');
    modalContent = '<figure><img src="' + src + '"';
    modalContent += paramToAtts(params);
    modalContent += '>';
    if (caption) {
      modalContent += '<caption class="block p-p8 text-p24">' + caption + '</caption>';
    }
    modalContent += '</figure>';

    modal.label = 'Image Modal';
  } else if ( mode === 'large' ) {
    modal.bg = 'bg-white max-w-7xl rounded-2xl';
    modalContent += $target.innerHTML;
  } else {
    modal.bg = 'bg-white max-w-p768 rounded-2xl';
    modalContent += $target.innerHTML;

    if ( $target ) {
      modalTitle = $target.getAttribute('data-title');
    }
  }

  modal.trigger = $e.target;

  if (modalTitle) {
    modal.heading = modalTitle;
  }

  if (modalContent) {
    $content.innerHTML = modalContent;
    modal.content = true;
  }

  // console.log(modalContent)

  // Make it active
  modal.show = true;
  modal.transition = true;

  setTimeout(function () {
    $dialog.focus();
    modal.transition = false;
  }, 100);

}

var cModal = function(ini) {

  return {

    id: ini.id,
    focusable: false,
    firstElement: false,
    lastElement: false,
    lastFocused: false,
    closing: false,

    init: function() {

      // Remove the default hidden value from the component
      this.$root.classList.remove('hidden');

    },

    activate: function() {
      document.querySelector('html').classList.add('overflow-y-clip');
    },

    showModal: function() {
      return this.$store.modal.show;
    },

    showHeading: function() {
      return this.$store.modal.heading;
    },

    getHeading: function() {
      return this.$store.modal.heading;
    },

    getContent: function() {
      return this.$store.modal.content;
    },

    getLabel: function() {
      return this.$store.modal.label;
    },

    modalClass: function ($bg) {
      let modalClass = Alpine.store('modal').width;
      if ( $bg === undefined ) {
        $bg = false;
      }
      if ( $bg ) {
        modalClass += ' ' + Alpine.store('modal').bg;
      }
      return modalClass;
    },

    closeModal: function() {

      if ( this.$store.modal.transition ) { return false; }

      // Clear the window freeze
      document.querySelector('html').classList.remove('overflow-y-clip');

      // Return focus to the element that triggered the modal
      if ( this.$store.modal.trigger ) {
        this.$store.modal.trigger.focus();
      }
      this.$store.modal.trigger = false;
      this.$store.modal.transition = true;

      // Set the show property back to false to actually hide the modal component
      this.$store.modal.show = false;

      setTimeout(function () {
        this.$store.modal.content = false;
        this.$store.modal.transition = false;
      }.bind(this), 400)

    },

    swapModal: function($newContent) {
      var $content = document.getElementById('modal-content');
      var $newContent = document.getElementById($newContent);

      if ( this.$store.modal.transition ) { return false; }

      this.$store.modal.transition = true;

      // Set the show property back to false to actually hide the modal component
      this.$store.modal.show = false;
      this.$store.modal.content = false;

      this.modalClass();

      $content.innerHTML = $newContent.innerHTML;

      setTimeout(function () {
        this.$store.modal.show = true;
        this.$store.modal.content = true;
        this.$store.modal.transition = false;
      }.bind(this), 400)

    },


    keyPress: function ($e) {

      let KEY_ESC = 27;
      // console.log($e);
      if ($e.keyCode === KEY_ESC ) {
        this.closeModal();
      }

    },

    showTranscript: function ($e) {

      $e.preventDefault();
      let maxHeight = 'calc(99.9999vh - (4rem + ' + this.$refs['dialog'].offsetHeight + 'px))';

      this.$store.modal.showTranscript = !this.$store.modal.showTranscript;
      this.$refs['transcript'].style.maxHeight = maxHeight;

    },

  }

}

export { cModalTrigger, cModal }