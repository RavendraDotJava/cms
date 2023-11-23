/**
 * CCFields module for Craft CMS
 *
 * CCFields JS
 *
 * @author    Craft&Crew
 * @copyright Copyright (c) 2021 Craft&Crew
 * @link      https://craftandcrew.ca/
 * @package   CCFieldsModule
 * @since     1.0.0
 */

if (!window.ressetModuleSettings) {
  window.resetModuleSettings = function ($event) {

    $event.preventDefault();
    let $settings = $($event.target).closest('.settings-wrap');
    $settings.find('input[type="checkbox"],input[type="radio"]').each(function () {
      $(this).prop('checked', false);
    });
    $settings.find('button.lightswitch').each(function () {
      $(this).removeClass('on').addClass('off');
      $(this).attr('aria-checked', 'false');
      $(this).closest('input').find('input[type="hidden"]').value(0);
    });

  }
}