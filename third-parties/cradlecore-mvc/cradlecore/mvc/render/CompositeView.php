<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of CompositeView
 *
 * @author alejandro.soto
 */ 
class CompositeView {
    
    /**
     * @var array $httpObject Is a main process unit where is stored current request data 
     */
    private $httpObject = null;
    
    public function __construct() {
    }
    
    
    /**
     * Executes the children modules to retrieve the output of them and then 
     * put it into the parent view
     *
     * @param array Is the list of modules instances names to be processed by ControllerChildInstancer
     * @param ControllerChildInstancer $childInstancer If a module has a child this object instance based on config
     * @return array Output of the modules to be displayed in the composite view
     * 
     */
    public function processCompositeChildren($modulesInstancesNames, $action, $childInstancer) {
        $composite = array();
        for ($i = 0; $i < count($modulesInstancesNames); $i++) {
            ob_start();
            $childInstancer->executeChild($modulesInstancesNames[$i], $action, $this->httpObject);
            $output = ob_get_contents();
            ob_clean();
            $composite[$modulesInstancesNames[$i]] = $output;
        }
        return $composite;
    }
    
    /**
     * Setter for httpObject
     * 
     * @param httpObject
     */
    public function setHttpObject($httpObject) {
        $this->httpObject = $httpObject;
    }
}
