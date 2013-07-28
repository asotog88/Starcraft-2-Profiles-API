<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/ControllerInstancer.php');
require_once(dirname(__FILE__) . '/../utils/Validator.php');
require_once(dirname(__FILE__) . '/../CradleCoreException.php');
require_once(dirname(__FILE__) . '/../frames/AssetsRenderer.php');

/**
 * Description of ControllerLoader
 *
 * @author alejandro.soto
 */
class ControllerLoader extends ControllerInstancer {

    /**
     *
     * @var array Current controller configuration
     */
    private $configuration = null;
    /**
     *
     * @var array Is a main process unit where we store current request data
     */
    private $httpObject;

    public function __construct() {

    }

    /**
     * Dispatch a request to specific parent conntroller
     *
     * @param array $configuration Is the configuration that matched with the route definition
     * @param string $action Action method of the controllers
     * @param array $httpObject Is a main process unit where we store current request data
     */
    public function dispatch($configuration, $action, $httpObject) {
        $this->httpObject = $httpObject;
        if (Validator::validateModule($configuration, $action)) {
            $hasValidModel = Validator::isValidModuleModel($configuration->type);
            $this->loadController($configuration, $action, $hasValidModel);
        }
    }

    /**
     * Starts  to load the controllers from parent module to its children
     * @param array $configuration Module configuration
     * @param string $action Controller action name
     * @param bool $hasModel OTHERif has valid model
     */
    private function loadController($configuration, $action, $hasModel) {
        $this->configuration = $configuration;
        $this->configuration->controllerName = $this->configuration->type . 'Controller';
        $this->configuration->modelName = $hasModel ? $this->configuration->type . 'Model' : null;
        $this->configuration->action = $action;
        if (isset($this->configuration->frame)) {
            $this->startControllersFrame();
        } else {
            $this->startControllersInit();
        }
    }

    /**
     * Initializes and start the controller logic and data rendering
     */
    private function startControllersInit() {
        $this->instanceController($this->configuration, $this->httpObject);
    }

    /**
     * Initialize with frame as parent html
     *
     */
    private function startControllersFrame() {
        $validFrame = Validator::isValidFrame($this->configuration->frame);
        if ($validFrame) {
            $this->executeAndCapture($validFrame);
            return;
        }
        CradleCoreException::MVC('Frame ' . $this->configuration->frame . ' does not exists.');
    }

    /**
     * Executes and add the html base frame
     *
     * @param string $frame Is the frame path location
     */
    private function executeAndCapture($frame) {
        $entryPoint = $this->httpObject['entryPoint'];
        ob_start();
        $this->instanceController($this->configuration, $this->httpObject);
        $markup = ob_get_contents();
        $title = (isset($this->configuration->title) ? $this->configuration->title : 'Cradlecore HtmlFrame');
        ob_end_clean();
        require_once($frame);   
    }

}
?>
