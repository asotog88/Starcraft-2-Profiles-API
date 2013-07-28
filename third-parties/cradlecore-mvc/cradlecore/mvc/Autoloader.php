<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

session_start();

/* encapsulates the cofiguration in global associative arrays */
$ROUTES = null;
$APPLICATION = null;
$DEVICES = null;
$APP_GLOBALS = null;
$CACHE_MANAGER = null;
$TOP_CSS_LIST = array();
$BOTTOM_CSS_LIST = array();
$TOP_JS_LIST = array();
$BOTTOM_JS_LIST = array();
$TOP_BLOB_LIST = array();
$BOTTOM_BLOB_LIST = array();

require_once(dirname(__FILE__) . '/utils/Utils.php');
require_once(dirname(__FILE__) . '/CradleCoreException.php');
require_once(dirname(__FILE__) . '/request/RequestListener.php');
require_once(dirname(__FILE__) . '/controller/CradleCoreController.php');
require_once(dirname(__FILE__) . '/cache/MemcacheManager.php');


/**
 * Description of Autoloader
 *
 * @author alejandro.soto
 */
class Autoloader {

    public function __construct() {
    	
        if ($this->initializeConfigurations()) {
            $requestListener = new RequestListener();
        }
    }

    /**
     * Initializes the configurations into associatives arrays
     * @return bool True if success
     */
    private function initializeConfigurations() {
        global $ROUTES, $APPLICATION, $DEVICES, $APP_DIRECTORY;
        $ROUTES = json_decode(Utils::fileToString($APP_DIRECTORY . '/configuration/routes.json'));
        $APPLICATION = json_decode(Utils::fileToString($APP_DIRECTORY . '/configuration/application.json'), true);
        $DEVICES = json_decode(Utils::fileToString($APP_DIRECTORY . '/configuration/devices.json'), true);
        if ($ROUTES == null) {
            CradleCoreException::MVC('routes.json file is missing something.');
            return false;
        }
        if ($APPLICATION == null) {
            CradleCoreException::MVC('application.json file is missing something.');
            return false;
        }
        if ($DEVICES == null) {
            CradleCoreException::MVC('devices.json file is missing something.');
            return false;
        }
        return $this->loadAplicationGlobals($APPLICATION);
    }

    /**
     * Loads the application globals variables based on current environment
     *
     * @param array $application Application.json decoded data
     * @return boolean True if application globals defined and false if not
     */
    private function loadAplicationGlobals($application) {
        global $APP_GLOBALS;
        if (isset($application['environment']) && isset($application['environments'])
                && array_key_exists($application['environment'], $application['environments'])) {
            $APP_GLOBALS = Utils::recursiveArrayToObject($application['environments'][$application['environment']]);
            $this->loadCacheManager($APP_GLOBALS);
            return true;
        }
        CradleCoreException::MVC('No environment defined in application.json .');
        return false;
    }

    /**
     * Initializes the cache manager or keep it null if cache was not set
     *
     * @param array $applicationGlobals Application valuesafes based on the current environment
     */
    private function loadCacheManager($applicationGlobals) {
        global $CACHE_MANAGER;
        if (isset($applicationGlobals->cache)) {
            $host = (isset($applicationGlobals->cache->host)) ? $applicationGlobals->cache->host : 'localhost';
            $port = (isset($applicationGlobals->cache->port)) ? $applicationGlobals->cache->port : 11211;
            $MemcacheManagerInstance = new MemcacheManager();
            $connected = $MemcacheManagerInstance->connect($host, $port);
            $CACHE_MANAGER = ($connected) ? $MemcacheManagerInstance : null;
        }
    }

}

?>
