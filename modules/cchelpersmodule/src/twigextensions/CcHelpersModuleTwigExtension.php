<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\cchelpersmodule\twigextensions;

use modules\cchelpersmodule\CcHelpersModule;
use modules\cchelpersmodule\models\ImageAttributes;
use modules\cchelpersmodule\models\ImagePlaceholder;
use modules\cchelpersmodule\models\VideoAttributes;
use modules\cchelpersmodule\models\VideoPlaceholder;
use modules\cchelpersmodule\models\PseudoEntry;
use modules\cchelpersmodule\models\PageHeader;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * The methods of this class are used to extend Twig. They provide a number
 * of filters and functions which either provide direct functionality or
 * act as an interface for templates to access helper functions.
 *
 * Twig reference:
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Craft&Crew
 * @package   CcHelpersModule
 * @since     1.0.0
 */
class CcHelpersModuleTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'CcHelpersModule';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('addslashes', [$this, 'addslashes']),
            new TwigFilter('srstring', [$this, 'srstring']),
            new TwigFilter('siteInclude', [$this, 'siteInclude']),
            new TwigFilter('widont', [$this, 'widont']),
            new TwigFilter('wpautop', [$this, 'wpautop']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [

            // Helper Functions
            new TwigFunction('print_r', [$this, 'print_r']),
            new TwigFunction('getVer', [$this, 'getVer']),
            new TwigFunction('htmlComment', [$this, 'htmlComment']),
            new TwigFunction('wfBreak', [$this, 'wfBreak']),
            new TwigFunction('hasProp', [$this, 'hasProp']),

            // Component Functions
            new TwigFunction('component', [$this, 'getComponentClasses']),
            new TwigFunction('getIcon', [$this, 'getIcon']),

            // Media Functions
            new TwigFunction('imagePlaceholder', [$this, 'imagePlaceholder']),
            new TwigFunction('imageAttributes', [$this, 'imageAttributes']),
            new TwigFunction('videoAttributes', [$this, 'videoAttributes']),
            new TwigFunction('videoPlaceholder', [$this, 'videoPlaceholder']),
            new TwigFunction('isVideo', [$this, 'isVideo']),

            // Entry Functions
            new TwigFunction('getPseudoEntry', [$this, 'getPseudoEntry']),
            new TwigFunction('getEntrySnippet', [$this, 'getEntrySnippet']),

            // Module Functions
            new TwigFunction('getModuleLayout', [$this, 'getModuleLayout']),
            new TwigFunction('setModuleTotal', [$this, 'setModuleTotal']),
            new TwigFunction('feedQueryParams', [$this, 'feedQueryParams']),
            new TwigFunction('getPageHeaderSettings', [$this, 'getPageHeaderSettings']),
            new TwigFunction('feedConfig', [$this, 'getFeedConfig']),


        ];
    }

    /** -----------------------------------------------------------------------------
     *  Helper Functions
     *  The functions in this grouping are helper functions that are primarily used
     *  to assist with templating, either by providing custom output or by filtering
     *  output.
     ** ----------------------------------------------------------------------------- */

    /**
     * This is a simple helper function, which is designed for use as
     * an alternative to dump(), which uses the print_r() PHP command.
     *
     * Additionally, it wraps the output in a <pre> tags for simpler
     * formatting within Twig output.
     *
     * @param null $text
     *
     * @return string
     */
    public function print_r($val = null)
    {
        echo '<pre>';
        print_r($val);
        echo '</pre>';
    }


    /**
     * This is a simple function for generation a version number to be
     * used both in TWIG, and within other functions and filters, as
     * appropriate.
     */
    public function getVer()
    {
        if (getenv('CRAFT_ENVIRONMENT') == 'dev') {
			return date('ymdhis');
        }
		return ( !empty(getenv('CRAFTENV_VER')) ) ? getenv('CRAFTENV_VER') : '1.0';
    }


    /**
     * This is a simple twig filter for outputting HTML comments in
     * TWIG. The comments only render when devMode is active, based
     * on the environment variables.
     *
     * @param null $comment - the HTML comment text.
     */
    public function htmlComment($comment = null)
    {
        if (getenv('CRAFT_ENVIRONMENT') == 'dev') {
            echo '<!-- ' . $comment . ' -->';
        }
    }


    /**
     * This is a simple twig filter for outputting HTML comments in
     * TWIG. The comments only render when devMode is active, based
     * on the environment variables.
     *
     * @param null $comment - the HTML comment text.
     */
    public function wfBreak($comment = null)
    {
        if (getenv('WIREFRAME_MODE') == 'true') {
            echo '<div role="presentation" class="bg-white h-p48"></div>';
        }
    }

    /**
     * This is a simple function tcan be used to check of an object has
     * a particular property and whether it's not empty.
     *
     * @param array|object $target - The target to check
     * @param string $field - The name of the property to check for
     *
     * @return boolean - returns true if the value is detected; otherwise, returns false.
     */
    function hasProp($target, $field)
    {
        if ( is_object($target) ) {
            if ( isset($target->$field) ) {
                if ( ! empty($target->$field) ) {
                    return true;
                }
            }
        } else if (is_array($target) ) {
            if ( isset($target[$field]) ) {
                if ( ! empty($target[$field]) ) {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * This is a simple filter to add the addslashes PHP function as a Twig filter.
     *
     * @param null $val - the string that requires slashes
     *
     * @return string - the processed string.
     */
    public function addslashes($val = null)
    {
        return addslashes($val);
    }


    /**
     * This is a simple Twig filter/function for generating a string where part of the
     * text is wrapped in a <span> to make it visible only to screen readers. This is
     * achieved by wrapping the target text in delimiters:
     *
     * Here is some text %for screen readers only%
     *
     * This is particularly useful when processing strings entered into fields through
     * the admin, as it provides content editors with a small degree of flexibility when
     * it comes to making accessible links.
     *
     * @param string $string - the string to be filtered
     *
     * @return string - returns a string with screen reader only text where applicable.
     */
    public function srstring($string)
    {
        $string = preg_replace('/\%([^\*]+)\%/', '<span class="sr-only">$1</span>', $string);
        return new \Twig\Markup( $string, 'UTF-8' );
    }


    /**
     * This is a Twig filter intended specifically for allowing us to "fork" Twig includes
     * according to the site ID. By including this filter on an include, we can check to see
     * whether a template exisits in a specifically named folder.
     *
     * We actually do the check in the forkTemplatePath() service method.
     *
     * @param string $template - the template path used in the Twig include
     *
     * @return string - the (potentially) modified template path
     */
    public function siteInclude($template) {
        return CcHelpersModule::$instance->helpers->forkTemplatePath($template);
    }


    /** -----------------------------------------------------------------------------
     *  Component Functions
     *  The functions in this grouping are related specifically to the creation and
     *  management of components.
     ** ----------------------------------------------------------------------------- */

    /**
     * This function gets custom classes for the specified component type and style.
     * It calls the getComponentClass service function, which works to pull in the appropriate
     * component classes from the config.
     *
     * @param string $type - the component type being requested
     * @param string $style - optional - the compoent style
     * @param string $class - optional - additional compoent classes to be passed in
     *
     * @return string - returns the list of classes
     */
    function getComponentClasses($type, $style = '', $class = '')
    {
        return CcHelpersModule::$instance->helpers->getComponentClasses($type, $style, $class);
    }


    /**
     * This is a simple Twig function for generating an SVG symbol icon. It's a quick
     * and efficient way of creating icons without using a Twig include or macro.
     *
     * The function also applies a version number from the getVer() function in order
     * to bust cahced versions of the icons.svg file.
     *
     * @param string $icon - the icon name
     * @param string $style - the icon style (uses the getComponentClasses() function)
     * @param string $class - additional classes (also passed via getComponentClasses())
     *
     * @return string - returns the symbol HTML
     */
    function getIcon($icon, $style = 'primary', $class = '')
    {
        if (getenv('CRAFT_ENVIRONMENT') == 'dev') {
			$ver = "now"|date('mdyhis');
        } else {
            // Production - env version number
			$ver = ( !empty(getenv('CRAFTENV_VER')) ) ? getenv('CRAFTENV_VER') : '1.0';
        }
        // echo $style;
        $iconClass = $this->getComponentClasses('icon', $style, $class);
        $iconHtml = '<svg role="presentation" class="' . $iconClass . '"><use xlink:href="/ui/icons.svg?' . $ver . '#icon-' . $icon . '" /></svg>';
        return new \Twig\Markup( $iconHtml, 'UTF-8' );
    }


    /** -----------------------------------------------------------------------------
     *  Media Functions
     *  The functions in this grouping are related specifically to the creation and
     *  handling of media assets.
     ** ----------------------------------------------------------------------------- */

    /**
     * This function gets an instance of the ImageAttributes class. The core functional concept
     * here is to provide a single class that will generate all of the required attributes
     * necessary to create and output fully responsive images.
     *
     * @param object $asset - the image asset used to generate the attributes object.
     * @param object $mobileImage - an optional alternate mobile image
     * @param object $mq - the media query indicating at what point the mobile image should
     *   be substituted in.
     *
     * @return object - returns an instance ImageAttribures class.
     */
    function imageAttributes($asset, $mobileImage = false, $mq = false)
    {
        return new ImageAttributes($asset, $mobileImage, $mq);
    }


    /**
     * This function generates an image placeholder object, by implementing an instance
     * of the ImagePlaceholder class, which creates an object that emulates the
     * ImageAttributes object sufficiently for the Twig templates to be able to
     * handle either object through the same properties and methods.
     *
     * Optionally, if the media identifier begins with @vidsum, it instead uses
     * the VideoPlaceholder class.
     *
     * @param string $id - the placeholder identifier.
     *
     * @return object - returns an instance of the placeholder class.
     */
    function imagePlaceholder($id)
    {
        if ( substr($id, 0, 7) == '@vidsum' ) {
            return new VideoPlaceholder($id);
        }
        return new ImagePlaceholder($id);
    }


    /**
     * This function gets an instance of the VideoAttributes class. The core functional concept
     * here is to provide a single class that will generate all the require attributes to
     * output a video. Since the VideoAttributes extends the ImageAttributes class, it also
     * handles the creation of the same attributes required to make a responsive image for
     * the video's facade cover.
     *
     * @param object $asset - the image asset used to generate the attributes object.
     * @param object $mobileImage - an optional alternate mobile image
     * @param object $mq - the media query indicating at what point the mobile image should
     *   be substituted in.
     *
     * @return object - returns an instance VideoAttributes class.
     */
    function videoAttributes($asset, $mobileImage = false, $mq = false)
    {
        return new VideoAttributes($asset, $mobileImage, $mq);
    }


    /**
     * This function generates a video placeholder object, by implementing an instance
     * of the VideoPlaceholder class, which creates an object that emulates the
     * VideoAttributes class.
     *
     * @param string $url - the placeholder identifier.
     *
     * @return object - returns an instance of the placeholder class.
     */
    function videoPlaceholder($url)
    {
        $video = new VideoPlaceholder($url);
        return $video;
    }


    /**
     * This function simply checks if the supplied asset is a video.
     * It does this by checking the asset handle against a predefined string.
     *
     * By default the string is 'videos'
     * This can be changed if the volume handle is changed.
     *
     * @param object $asset - the asset object.
     *
     * @return boolean - returns true if the asset is a volume; false if not
     */
    function isVideo($asset)
    {
        $videoVolume = 'videos';
        $videoFile = 'videoFiles';

        if ( $this->hasProp($asset, 'volume') ) {
            if ( is_iterable($asset->volume) ) {
                return $asset->volume->handle === $videoVolume || $asset->volume->handle === $videoFile;
            } elseif ( $asset->volume === $videoVolume || $asset->volume === $videoFile ) {
                return true;
            }
        }
        return false;
    }


    /**
     * This function returns an instance of the PseudoEntry class.
     *
     * The idea here is to provide an object with the same attributes and methods
     * as the standard Entry class. This will allow certain models such as the
     * PageHeader to function when no Entry class exists.
     *
     * It does not require any parameters; rather, it determines the required
     * values based on the URL path.
     *
     * @return boolean - returns true if the asset is a volume; false if not
     */
    function getPseudoEntry()
    {
        return new PseudoEntry();
    }


    /**
     * This function gets an instance of the PageHeader class. The class accepts
     * the entry object, and returns a common object which normalizes all of
     * the attributes required by the _pageHeader.twig partial template.
     *
     * @param object $entry - the entry object.
     *
     * @return object - returns the page header object.
     */
    function getPageHeaderSettings($entry)
    {
        return new PageHeader($entry);
    }


    /**
     * This function generates the parameters required for a feed query.
     * We use this method in order to separate the logic involved in setting up
     * these parameters here instead of in Twig.
     *
     * @param object $config - the configuration array.
     * @param object $exclude - the exclude id.
     *
     * @return object - returns true if the asset is a volume; false if not
     */
    function feedQueryParams($config, $exclude = false)
    {
        return CcHelpersModule::$instance->helpers->feedQueryParams($config, $exclude);
    }


    /**
     * This Twig function calls the getEntrySnippet() function, which is used to
     * generate a descriptive snippet for the entry, based on a hierarchy of fields.
     *
     * @param object $entry - the entry object
     * @param int    $trim  - the desired length if the snippet.
     *
     * @return string
     */
    function getEntrySnippet($entry, $trim = 160)
    {
        return CcHelpersModule::$instance->helpers->getEntrySnippet($entry, $trim);
    }


    /**
     * This Twig function is used to call the getFeedConfig() helper function,
     * which returns the configuration object for a specific feed, for use
     * within Twig templates.
     *
     * @param string $feed - the name of the feed
     * @param string $entry - the entry object
     *
     * @return object
     */
    function getFeedConfig($feed, $entry)
    {
        return CcHelpersModule::$instance->helpers->getFeedConfig($feed, $entry);
    }


    /**
     * This Twig function is used to call the getModuleLayout() helper function,
     * which generates a series of module configration values to assist
     * with the rendering of module backgrounds and the relationship between
     * consecutive modules.
     *
     * @param string $block - the module matrix block
     * @param string $dataOnly - determines whether only the module data should
     *   be included.
     *
     * @return object - returns the module block object.
     */
    function getModuleLayout($block, $dataOnly = false)
    {
        return CcHelpersModule::$instance->helpers->getModuleLayout($block, $dataOnly);
    }


    function setModuleTotal($total)
    {
        $GLOBALS['_modules:total'] = $total;
        return $GLOBALS['_modules:total'];
    }


    /**
     * This is a Twig filter function that can use used to attempt to mitigate the inclusion of
     * widows within strings. It will only apply if the last word is shorter than 6 characters.
     * Primarily used for titles.
     *
     * @param string $string - the string to be modified.
     *
     * @return string
     */
    function widont($string = '')
    {
        $string = rtrim($string);
        $maxLen = 6;
        $space = strrpos($string, ' ');
        $len = strlen(substr($string, $space + 1));
        if ($space !== false && $len <= $maxLen)
        {
            $string = substr($string, 0, $space).'&nbsp;'.substr($string, $space + 1);
        }
        return new \Twig\Markup( $string, 'UTF-8' );
    }


    /**
     * This is a Twig filter function that is primarily used when dealing with content imported
     * from WordPress. It is, essentially, just a clone of the WordPress wpautop() function from
     * the WordPress open source core.
     *
     * Because WordPress tends to store WYSIWYG content in an unprocessed format, this filter
     * is often required to ensure proper HTML tags are applied to imported content.
     *
     * Use with caution.
     *
     * @param string $pee
     * @param string $br
     *
     * @return string - the formatted string.
     */
    function wpautop( $pee, $br = true ) {
        $pre_tags = array();

        if ( trim( $pee ) === '' ) {
            return '';
        }

        $pee = str_replace('<a class="btn btn--secondary"', "\n<a class=\"c-btn c-btn-secondary\"", $pee);

        // Just to make things a little easier, pad the end.
        $pee = $pee . "\n";

        /*
        * Pre tags shouldn't be touched by autop.
        * Replace pre tags with placeholders and bring them back after autop.
        */
        if ( strpos( $pee, '<pre' ) !== false ) {
            $pee_parts = explode( '</pre>', $pee );
            $last_pee  = array_pop( $pee_parts );
            $pee       = '';
            $i         = 0;

            foreach ( $pee_parts as $pee_part ) {
                $start = strpos( $pee_part, '<pre' );

                // Malformed HTML?
                if ( false === $start ) {
                    $pee .= $pee_part;
                    continue;
                }

                $name              = "<pre wp-pre-tag-$i></pre>";
                $pre_tags[ $name ] = substr( $pee_part, $start ) . '</pre>';

                $pee .= substr( $pee_part, 0, $start ) . $name;
                $i++;
            }

            $pee .= $last_pee;
        }
        // Change multiple <br>'s into two line breaks, which will turn into paragraphs.
        $pee = preg_replace( '|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee );

        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

        // Add a double line break above block-level opening tags.
        $pee = preg_replace( '!(<' . $allblocks . '[\s/>])!', "\n\n$1", $pee );

        // Add a double line break below block-level closing tags.
        $pee = preg_replace( '!(</' . $allblocks . '>)!', "$1\n\n", $pee );

        // Add a double line break after hr tags, which are self closing.
        $pee = preg_replace( '!(<hr\s*?/?>)!', "$1\n\n", $pee );

        // Standardize newline characters to "\n".
        $pee = str_replace( array( "\r\n", "\r" ), "\n", $pee );

        // Find newlines in all elements and add placeholders.
        //$pee = wp_replace_in_html_tags( $pee, array( "\n" => ' <!-- wpnl --> ' ) );

        // Collapse line breaks before and after <option> elements so they don't get autop'd.
        if ( strpos( $pee, '<option' ) !== false ) {
            $pee = preg_replace( '|\s*<option|', '<option', $pee );
            $pee = preg_replace( '|</option>\s*|', '</option>', $pee );
        }

        /*
        * Collapse line breaks inside <object> elements, before <param> and <embed> elements
        * so they don't get autop'd.
        */
        if ( strpos( $pee, '</object>' ) !== false ) {
            $pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
            $pee = preg_replace( '|\s*</object>|', '</object>', $pee );
            $pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
        }

        /*
        * Collapse line breaks inside <audio> and <video> elements,
        * before and after <source> and <track> elements.
        */
        if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
            $pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
            $pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
            $pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
        }

        // Collapse line breaks before and after <figcaption> elements.
        if ( strpos( $pee, '<figcaption' ) !== false ) {
            $pee = preg_replace( '|\s*(<figcaption[^>]*>)|', '$1', $pee );
            $pee = preg_replace( '|</figcaption>\s*|', '</figcaption>', $pee );
        }

        // Remove more than two contiguous line breaks.
        $pee = preg_replace( "/\n\n+/", "\n\n", $pee );

        // Split up the contents into an array of strings, separated by double line breaks.
        $pees = preg_split( '/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY );

        // Reset $pee prior to rebuilding.
        $pee = '';

        // Rebuild the content as a string, wrapping every bit with a <p>.
        foreach ( $pees as $tinkle ) {
            $pee .= '<p>' . trim( $tinkle, "\n" ) . "</p>\n";
        }

        // Under certain strange conditions it could create a P of entirely whitespace.
        $pee = preg_replace( '|<p>\s*</p>|', '', $pee );

        // Add a closing <p> inside <div>, <address>, or <form> tag if missing.
        $pee = preg_replace( '!<p>([^<]+)</(div|address|form)>!', '<p>$1</p></$2>', $pee );

        // If an opening or closing block element tag is wrapped in a <p>, unwrap it.
        $pee = preg_replace( '!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $pee );

        // In some cases <li> may get wrapped in <p>, fix them.
        $pee = preg_replace( '|<p>(<li.+?)</p>|', '$1', $pee );

        // If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
        $pee = preg_replace( '|<p><blockquote([^>]*)>|i', '<blockquote$1><p>', $pee );
        $pee = str_replace( '</blockquote></p>', '</p></blockquote>', $pee );

        // If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
        $pee = preg_replace( '!<p>\s*(</?' . $allblocks . '[^>]*>)!', '$1', $pee );

        // If an opening or closing block element tag is followed by a closing <p> tag, remove it.
        $pee = preg_replace( '!(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $pee );

        // Optionally insert line breaks.
        if ( $br ) {
            // Replace newlines that shouldn't be touched with a placeholder.
            //$pee = preg_replace_callback( '/<(script|style|svg).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee );

            // Normalize <br>
            $pee = str_replace( array( '<br>', '<br/>' ), '<br />', $pee );

            // Replace any new line characters that aren't preceded by a <br /> with a <br />.
            $pee = preg_replace( '|(?<!<br />)\s*\n|', "<br />\n", $pee );

            // Replace newline placeholders with newlines.
            $pee = str_replace( '<WPPreserveNewline />', "\n", $pee );
        }

        // If a <br /> tag is after an opening or closing block tag, remove it.
        $pee = preg_replace( '!(</?' . $allblocks . '[^>]*>)\s*<br />!', '$1', $pee );

        // If a <br /> tag is before a subset of opening or closing block tags, remove it.
        $pee = preg_replace( '!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee );
        $pee = preg_replace( "|\n</p>$|", '</p>', $pee );

        // Replace placeholder <pre> tags with their original content.
        if ( ! empty( $pre_tags ) ) {
            $pee = str_replace( array_keys( $pre_tags ), array_values( $pre_tags ), $pee );
        }

        // Restore newlines in all elements.
        if ( false !== strpos( $pee, '<!-- wpnl -->' ) ) {
            $pee = str_replace( array( ' <!-- wpnl --> ', '<!-- wpnl -->' ), "\n", $pee );
        }

        return new \Twig\Markup( $pee, 'UTF-8' );
    }


}
