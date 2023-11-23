/**
 * CCFields module for Craft CMS
 *
 * Instructions Field JS
 *
 * @author    Craft&Crew
 * @copyright Copyright (c) 2021 Craft&Crew
 * @link      https://craftandcrew.ca/
 * @package   CCFieldsModule
 * @since     1.0.0CCFieldsModuleInstructions
 */

 ;(function ( $, window, document, undefined ) {

    var pluginName = "CCFieldsModuleIcon",
        defaults = {
        };

    // Plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function(id) {
            var _this = this;

            $(function () {

                $('.cc-icon-btn').on('click', function($e){
                    $e.preventDefault();
                    
                    var $btn = $(this),
                        $wrap = $btn.closest('.cc-icon-picker'),
                        $clear = $wrap.find('.cc-icon-clear'),
                        id = $(this).data('icon-id'),
                        field = $wrap.closest('.cc-icon-picker').data('field-id');

                    $wrap.find('.cc-icon-field').val(id);
                    $wrap.find('.cc-icon-btn').removeClass('js-active').addClass('js-inactive');
                    $btn.removeClass('js-inactive').addClass('js-active');
                    $clear.fadeIn();
                    
                });

                $('.cc-icon-clear').on('click', function($e){
                    $e.preventDefault();

                    var $clear = $(this),
                        $wrap = $clear.closest('.cc-icon-picker');

                    $wrap.find('.cc-icon-field').val('');
                    $wrap.find('.cc-icon-btn').removeClass('js-active js-inactive');
                    $clear.fadeOut();
                });

/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */

            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );
