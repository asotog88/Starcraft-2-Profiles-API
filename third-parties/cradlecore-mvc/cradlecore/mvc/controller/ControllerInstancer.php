<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../CradleCoreException.php');

/**
 * Description of ControllerInstancer
 *
 * @author alejandro.soto
 */
class ControllerInstancer {
    
    public function  __construct() {
        
    }

    /**
     * Instance a controller and call its action method
     *
     * @param array $configuration Current controller configuration
     * @param array $httpObject Is a main process unit where we store current request data
     */
    public function instanceController($configuration, $httpObject) {
        $reflectionClass = new ReflectionClass($configuration->controllerName);
        $objectInstanced = $reflectionClass->newInstance();
        $objectInstanced->setConfiguration($configuration);
        $objectInstanced->http->setHttpObject($httpObject);
        $objectInstanced->setHttpObject($httpObject);
        $objectInstanced->params->setParams($httpObject['routeParams'], $httpObject['params']);
        $this->instanceModel($objectInstanced, $configuration->modelName);
        $result = call_user_func(array($objectInstanced, $configuration->action)); 
    }

    /**
     *
     * @param object $controllerInstance Is a controller class instance
     * @param string $modelClassName Name of the model if exists
     */
    private function instanceModel(&$controllerInstance, $modelClassName) {
        if ($modelClassName) {
             $reflectionClass = new ReflectionClass($modelClassName);
             $controllerInstance->setModel($reflectionClass->newInstance());
        }
    }

}
?>
