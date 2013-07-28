<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../render/ViewRenderer.php');
require_once(dirname(__FILE__) . '/IBaseController.php');
require_once(dirname(__FILE__) . '/ControllerChildInstancer.php');
require_once(dirname(__FILE__) . '/addons/Assets.php');
require_once(dirname(__FILE__) . '/addons/Http.php');
require_once(dirname(__FILE__) . '/addons/Params.php');
require_once(dirname(__FILE__) . '/addons/Cache.php');
require_once(dirname(__FILE__) . '/addons/Device.php');
require_once(dirname(__FILE__) . '/addons/Session.php');

/**
 * Description of CoreController
 *
 * @author alejandro.soto
 */
class CradleCoreController extends ViewRenderer implements IBaseController {

    /**
     *
     * @var Assets Operations with assets such as add css, js and other static variables
     */
    public $assets;
    /**
     *
     * @var Http Http operations change headers, user agents, redirection etc
     */
    public $http;
    /**
     *
     * @var object To reference controller models
     */
    public $model;
    /**
     *
     * @var Device Retrieves infomation about the current request mobile device
     */
    public $device;
    /**
     *
     * @var Params To reference the request params
     */
    public $params;
    /**
     *
     * @var Session Helper to manage the session of the current user
     */
    public $session;
    /**
     *
     * @var array The list of values to rendered or processed in the view
     */
    private $viewValuesList = null;
    /**
     *
     * @var ControllerChildInstancer If a module has a child this object instance based on config
     */
    private $childInstancer;
    /**
     *
     * @var array Current controller configuration
     */
    private $configuration = null;
    /**
     *
     * @var string Controller action function to be executed
     */
    private $action;
    /**
     *
     * @var array Current module instance configuration var exposed to set custom values to be read
     */
    public $config = null;
    /**
     *
     * @var array Stores application global configuration values defined in application.json environment sections
     */
    public $AppConfig = null;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Sets the current configuration
     *
     * @param array $configuration Current controller configuration
     */
    public function setConfiguration($configuration) {
        global $APP_GLOBALS;
        $this->AppConfig = $APP_GLOBALS;
        $this->assets = new Assets();
        $this->http = new Http();
        $this->params = new Params();
        $this->session = new Session();
        $this->cache = new Cache();
        $this->device = new Device();
        $this->configuration = $configuration;
        $this->config = (isset($configuration->config)) ? $configuration->config : null;
        $this->setConfig($configuration);
        $this->setAction($configuration->action);
        $childrenConfig = (isset($configuration->config)) && isset($configuration->config->children) ? $configuration->config->children : null;
        $this->childInstancer = new ControllerChildInstancer($childrenConfig, $configuration->type);
        parent::setChildInstancer($this->childInstancer);
    }

    /**
     * Sets controller action
     *
     * @param string $action Controller action function to be executed
     */
    private function setAction($action) {
        $this->action = $action;
    }

    /**
     * Set the current models
     *
     * @param object $model An object with models associated
     */
    public function setModel($model) {
        $this->model = $model;
    }

    /**
     * Executes the view rendering and starts the process of the children modules
     *
     * @param array $viewValues Values to be passed to the view
     */
    public function done($viewValues = array()) {
        $this->viewValuesList = $viewValues;
        $this->renderView($viewValues);
    }

    /**
     * Function used from the view to retrieve the values set in the controller
     *
     * @param string $key The key of the var value to be returned
     * @return var 
     */
    public function get($key) {
        if (isset($this->viewValuesList[$key])) {
            return $this->viewValuesList[$key];
        }
        return null;
    }

    /**
     * Retrieve a child module from a parent module based on application.json configuration
     *
     * @param string $key The key of the child module to be returned
     *
     */
    public function child($key) {
        $this->childInstancer->executeChild($key, $this->action, $this->http->getHttpObject());
    }
    
    /**
     * Sets page title from controller instead of application.json
     * Dynamically the title can be set it up
     * 
     * @param string $title Page title
     * 
     */
    public function setPageTitle($title) {
        $this->configuration->title = $title;
    }

}
?>
