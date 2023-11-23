/**
 * CC Helpers module for Craft CMS
 *
 * CC Helpers JS
 *
 * @author    Craft&Crew
 * @copyright Copyright (c) 2020 Craft&Crew
 * @link      https://craftandcrew.ca/
 * @package   CcHelpersModule
 * @since     1.0.0
 */

 ;(function ( $, window, document, undefined ) {

  // Define our function
  let matrixCollapse = () => {

    let limit = 2;
    let check = false;

    // Check if the required function is defined
    if ( Craft) {
      if (Craft.MatrixInput) {
        if (Craft.MatrixInput.rememberCollapsedBlockId) {

          // Get the matrix blocks
          let matrixBlocks = $('.blocks > .matrixblock');

          // If there are more than our limit...
          if ( matrixBlocks.length > limit ) {

            // ...
            matrixBlocks.each(function () {
              $(this).addClass('collapsed');
              Craft.MatrixInput.rememberCollapsedBlockId($(this).data('id'));
            });
            check = true;
          }
        }
      }
    }

    // Otherwise, set timeout to wait.
    if ( ! check ) {
      setTimeout(() => {
        matrixCollapse();
      }, 10)
    }
  }

  matrixCollapse();

})( jQuery, window, document );