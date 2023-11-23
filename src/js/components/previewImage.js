function cPreviewImage(ini) {

  return {
    imageUploadId: ini.imageUploadId,
    imagePreviewId: ini.imagePreviewId,
    files: null,

    init: function () {
      // console.log('test');
    },

    onClick: function () {

      this.getImgUrl(this.$el.value, (imgBlob) => {
        var fileInput = document.getElementById(this.imageUploadId);
        const dataTransfer = new DataTransfer();

        let file = new File([imgBlob], this.$el.id + '.jpg', {
          type: "image/jpeg",
        });

        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
      })
    },

    getImgUrl: function(url, callback) {
      var xhr = new XMLHttpRequest();
      xhr.onload = function() {
          callback(xhr.response);
      };
      xhr.open('GET', url);
      xhr.responseType = 'blob';
      xhr.send();
    },

    showPreview: function () {
      var oFReader = new FileReader();
      var image = document.getElementById(this.imagePreviewId);

      document.getElementById('reviewPhotoUpload').checked = true;

      oFReader.readAsDataURL(document.getElementById(this.imageUploadId).files[0]);

      oFReader.onload = function (oFREvent) {
        image.src = oFREvent.target.result;
      };
    }
  }
}

export { cPreviewImage }