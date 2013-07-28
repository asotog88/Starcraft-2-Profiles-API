<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../CradleCoreException.php');
require_once(dirname(__FILE__) . '/../controller/ControllerLoader.php');

/**
 * Description of ControllerChildInstancer
 *
 * @author alejandro.soto
 */
class ControllerChildInstancer extends ControllerLoader {

    /**
     *
     * @var array Current controller children configuration
     */
    private $childrenConfiguration = null;

    /**
     *
     * @var string Children parent name
     */
    private $parentType;

    /**
     *
     * @var bool If the current module has valid children
     */
    private $hasValidChildren;

    /**
     *
     * @param string $type Module type name
     * @param array $childrenConfiguration Current controller children configuration
     */
    public function __construct($childrenConfiguration, $type) {
        $this->parentType = $type;
        $this->childrenConfiguration = $childrenConfiguration;
        $this->hasValidChildren = $this->isValidChildrenCount();
    }

    /**
     * Retrieve a child module from a parent module based on application.json configuration
     *
     * @param string $key The key of the child module to be returned
     * @param string $action Controller action function to be executed
     * @param array $httpObject Is a main process unit where is stored current request data
     */
    public function executeChild($key, $action, $httpObject) {
        if ($this->hasValidChildren) {
            $childConfiguration = $this->childConfiguration($key);
            $action = ($childConfiguration != null && isset($childConfiguration->action) ? $childConfiguration->action : $action);
            $this->dispatch($childConfiguration, $action, $httpObject);
        }
    }

    /**
     * Retrieves from the tree an specific module configuration
     *
     * @param string $key The key of the child module to be returned
     * @return array Child configuration
     */
    private function childConfiguration($key) {
        foreach ($this->childrenConfiguration as $module => $config) {
            if ($module == $key) {
                return $config;
            }
        }
        return null;
    }

    /**
     * Validate if a children tree has children
     *
     * @return bool
     */
    private function isValidChildrenCount() {
        $count = 0;
        if ($this->childrenConfiguration) {
            foreach ($this->childrenConfiguration as $key => $value) {
                $count++;
            }
        }
        return ($this->childrenConfiguration && $count != 0);
    }

}

?>
