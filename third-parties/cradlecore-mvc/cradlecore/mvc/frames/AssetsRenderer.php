<?php

/**
 * Description of AssetsRenderer
 *
 * @author alejandro.soto
 */
class AssetsRenderer {

    /**
     * Add the assets in the top of the page
     *
     * @param array $httpObject
     */
    public static function addTopAssets($httpObject) {
        self::addTopCss($httpObject);
        self::addTopBlob($httpObject);
        self::addTopJs($httpObject);
    }

    /**
     * Add css tags to markup
     *
     * @global array $CSS_LIST Styles list
     * @param array $httpObject
     */
    private static function addTopCss($httpObject) {
        global $TOP_CSS_LIST;
        for ($i = 0; $i < count($TOP_CSS_LIST); $i++) {
            $cssHref = self::assetUrl($httpObject, $TOP_CSS_LIST[$i]);
            echo '<link rel="stylesheet" type="text/css" href="' . $cssHref . '"/>' . "\n";
        }
    }

    /**
     * Add js tags to markup
     *
     * @global array $TOP_JS_LIST Styles list
     * @param array $httpObject
     */
    private static function addTopJs($httpObject) {
        global $TOP_JS_LIST;
        for ($i = 0; $i < count($TOP_JS_LIST); $i++) {
            $jsHref = self::assetUrl($httpObject, $TOP_JS_LIST[$i]);
            echo '<script type="text/javascript" src="' . $jsHref . '"></script>' . "\n";
        }
    }

    /**
     * Add blob tags to markup e.g metadata
     *
     * @global array $TOP_BLOB_LIST Blob list
     * @param array $httpObject
     */
    private static function addTopBlob($httpObject) {
        global $TOP_BLOB_LIST;
        for ($i = 0; $i < count($TOP_BLOB_LIST); $i++) {
            echo $TOP_BLOB_LIST[$i] . "\n";
        }
    }


    /**
     * Add the assets in the bottom of the page
     *
     * @param array $httpObject
     */
    public static function addBottomAssets($httpObject) {
        self::addBottomCss($httpObject);
        self::addBottomBlob($httpObject);
        self::addBottomJs($httpObject);
    }

    /**
     * Add css tags to markup
     *
     * @global array $BOTTOM_CSS_LIST Styles list
     * @param array $httpObject
     */
    private static function addBottomCss($httpObject) {
        global $BOTTOM_CSS_LIST;
        for ($i = 0; $i < count($BOTTOM_CSS_LIST); $i++) {
            $cssHref = self::assetUrl($httpObject, $BOTTOM_CSS_LIST[$i]);
            echo '<link rel="stylesheet" type="text/css" href="' . $cssHref . '"/>' . "\n";
        }
    }

    /**
     * Add js tags to markup
     *
     * @global array $BOTTOM_JS_LIST Styles list
     * @param array $httpObject
     */
    private static function addBottomJs($httpObject) {
        global $BOTTOM_JS_LIST;
        for ($i = 0; $i < count($BOTTOM_JS_LIST); $i++) {
            $jsHref = self::assetUrl($httpObject, $BOTTOM_JS_LIST[$i]);
            echo '<script type="text/javascript" src="' . $jsHref . '"></script>' . "\n";
        }
    }

    /**
     * Add blob tags to markup e.g metadata
     *
     * @global array $BOTTOM_BLOB_LIST Blob list
     * @param array $httpObject
     */
    private static function addBottomBlob($httpObject) {
        global $BOTTOM_BLOB_LIST;
        for ($i = 0; $i < count($BOTTOM_BLOB_LIST); $i++) {
            echo $BOTTOM_BLOB_LIST[$i] . "\n";
        }
    }

    /**
     * Validates if is an internal or external asset
     *
     * @param array $httpObject
     * @param string $assetPath Asset url or path
     * @return string
     */
    private static function assetUrl($httpObject, $assetPath) {
        return (substr($assetPath, 0, 4) == 'http') ? $assetPath : $httpObject['entryPoint'] . $assetPath;
    }

}

?>
