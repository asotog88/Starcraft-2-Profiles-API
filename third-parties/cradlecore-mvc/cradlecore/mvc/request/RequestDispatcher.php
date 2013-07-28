<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../utils/Utils.php');
require_once(dirname(__FILE__) . '/../utils/Validator.php');
require_once(dirname(__FILE__) . '/../CradleCoreException.php');
require_once(dirname(__FILE__) . '/../controller/ControllerLoader.php');

/**
 * Description of RequestDispatcher
 *
 * @author alejandro.soto
 */
class RequestDispatcher extends ControllerLoader {

    /**
     *
     * @var array Is a main process unit where we store current request data
     */
    private $httpObject;
    
    /**
     *
     * @var array Encapsulates a route matched
     */
    private $route;

    /**
     *
     * @param associative array $httpObject Is a main process unit where we store current request data
     * @param associative array $route The route matched defined in the routes mapping configuration
     */
    public function __construct($httpObject, $route) {
        $this->httpObject = $httpObject;
        $this->route = $route;
        $this->dispatchToModuleConfig();
    }

    /**
     * Starts to search a configuration that matches with the route call field
     *
     */
    private function dispatchToModuleConfig() {
        global $APPLICATION;
        $call = $this->moduleInstanceNameFromRoute();
        if ($call != null) {
            foreach ($APPLICATION['modules_configuration'] as $instanceName => $configuration) {
                if ($call['instanceName'] == $instanceName) {
                    $this->dispatchToController($configuration, $call['action']);
                    return;
                }
            }
            CradleCoreException::MVC('No modules were defined with ' . $call['instanceName'] . ' name.');
            return;
        }
        CradleCoreException::MVC('Call field in route ' . $this->route->name . ' was not defined correctly.');
    }

    /**
     * Dispatch a request to specific parent conntroller
     *
     * @param array $configuration Is the configuration that matched with the route definition
     * @param string $action Action method of the controllers
     */
    private function dispatchToController($configuration, $action) {
        global $APPLICATION;
        $configuration = Utils::recursiveArrayToObject($this->checkParentConfiguration($configuration, $APPLICATION));
        $this->dispatch($configuration, $action, $this->httpObject);
    }

    /**
     * Checks if an instance definition in json file has parent to extends
     * and reuse its configurations
     *
     * @param <type> $configuration
     * @param <type> $applicationConfig
     * @return array Configuration tree
     */
    private function checkParentConfiguration($configuration, $applicationConfig) {
        if (isset($configuration['extends'])) {
            foreach ($applicationConfig['modules_configuration'] as $instanceName => $parentConfiguration) {
                if ($configuration['extends'] == $instanceName) {
                    unset ($configuration['extends']);
                    $mergedArray = Utils::mergeArrays($parentConfiguration, $configuration);
                    return $this->checkParentConfiguration($mergedArray, $applicationConfig);
                }
            }
            return $configuration;
        }
        return $configuration;
    }

    /**
     * Retrieve module instance name and action from route configuration
     * @return array An associative array with the
     * module instance name (instanceName) and an action (action)name
     */
    private function moduleInstanceNameFromRoute() {
        if (isset($this->route->call)) {
            $call = explode('.', $this->route->call);
            /* Only has to have 2 indexes one for instance name and other for the action */
            if (count($call) == 2) {
                $callObject = array();
                $callObject['instanceName'] = $call[0];
                $callObject['action'] = $call[1];
                return $callObject;
            }
            return null;
        }
        return null;
    }

}

?>
