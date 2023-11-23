function cComparisonChart(ini) {

  return {
    mq: ini.mq,
    largeLayout: true,
    selectedOptions: ini.selectedOptions,

    init: function () {
      this.onResize();
    },

    onChange: function () {
      var $target = this.$event.target; // The event target <select>.
      var selectedOption = $target.selectedIndex; // The selected <option> from the event target.
      var headerIndex = $target.dataset.index; // The index of the header where the <select> list resides.
      var backgroundColor = $target.options[selectedOption].dataset.color; // The background color for the selected option
      var heading = $target.closest('h3'); // The heading that contains the select options
      var columns = this.$refs['container'].querySelectorAll('[data-column]'); // The columns contiaining info
      var _this = this; // scoping this to be used in forEach

      this.updateSelectedOptions(this.selectedOptions, headerIndex, selectedOption);

      this.changeText(heading, $target.options[selectedOption].value);

      this.changeColor(heading, backgroundColor)

      this.checkSelectedOptions(selectedOption);

      columns.forEach(function ($value, $i) {
        var columnIndex = $value.dataset.column;

        if (columnIndex == selectedOption) {
          if(headerIndex == '0') {
            $value.classList.add('order-1');
          } else if (headerIndex == '1') {
            $value.classList.add('order-2');
          }
        } else if (!_this.checkSelectedOptions(Number(columnIndex))) {
          $value.classList.remove('order-1', 'order-2');
        }
      });
    },


    updateSelectedOptions: function ($array, $index, $newValue) {
      $array[$index] = $newValue;
    },

    changeColor: function ($option, $bgcolor) {
      $option.style.background = $bgcolor;
      $option.querySelector('span[data-arrow]').style.background = $bgcolor;
    },

    changeText: function($heading, $text) {
      $heading.querySelector('span[data-heading]').innerHTML = $text;
    },

    checkSelectedOptions: function ($option) {
      if(this.selectedOptions.includes($option)) {
        return true;
      }else{
        return false;
      }
    },

    onResize: function (e) {
      this.largeLayout = this.$breakpoint(this.mq);
    }
  }
}

export { cComparisonChart }