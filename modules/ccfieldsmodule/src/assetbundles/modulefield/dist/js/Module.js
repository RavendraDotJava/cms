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

    var pluginName = "CCFieldsModuleModule",
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

                $('.idmask').on('input', function($e) {

                    // Get the value
                    let value = $e.target.value;

                    // Remove leading numbers
                    while (!value.substr(0, 1).match(/[a-z]/gi) && value.length > 0) {
                        value = value.substr(1);
                    }

                    // Remove invalid characters
                    value = value.replace(/[^a-z0-9\_\-]/gi, '');

                    // Reset the value
                    $e.target.value = value;         
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

