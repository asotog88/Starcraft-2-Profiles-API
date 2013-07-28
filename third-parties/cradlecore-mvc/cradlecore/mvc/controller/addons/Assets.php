<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * Description of Assets
 *
 * @author alejandro.soto
 */
class Assets {

    /**
     * Contructor
     *
     * @param array $jsList List of javascript files
     * @param array $cssList List of styles files
     * @param array $blob List of blob data
     */
    public function __construct() {

    }

    /**
     * Adds a css to the css list to be rendered on page
     *
     * @param string $cssLocation Css application location
     * @param string $position Position in markup 'top' or 'bottom'
     */
    public function addCss($cssLocation, $position = 'top') {
        global $TOP_CSS_LIST, $BOTTOM_CSS_LIST;
        switch ($position) {
            case 'top': $TOP_CSS_LIST[] = $cssLocation;
                break;
            case 'bottom': $BOTTOM_CSS_LIST[] = $cssLocation;
                break;
            default: $TOP_CSS_LIST[] = $cssLocation;
                break;
        }
    }

    /**
     * Adds a js to the js list to be rendered on page
     *
     * @param string $jsLocation Js application location
     */
    public function addJs($jsLocation, $position = 'top') {
        global $TOP_JS_LIST, $BOTTOM_JS_LIST;
        switch ($position) {
            case 'top': $TOP_JS_LIST[] = $jsLocation;
                break;
            case 'bottom': $BOTTOM_JS_LIST[] = $jsLocation;
                break;
            default: $TOP_JS_LIST[] = $jsLocation;
                break;
        }
    }

    /**
     * Adds a blob to the blob list to be rendered on page
     *
     * @param string $tag Blob tag e.g meta
     */
    public function addBlob($tag, $position = 'top') {
        global $TOP_BLOB_LIST, $BOTTOM_BLOB_LIST;
         switch ($position) {
            case 'top': $TOP_BLOB_LIST[] = $tag;
                break;
            case 'bottom': $BOTTOM_BLOB_LIST[] = $tag;
                break;
            default: $TOP_BLOB_LIST[] = $tag;
                break;
        }
    }

}

?>
