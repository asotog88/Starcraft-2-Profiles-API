<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/IBaseView.php');
require_once(dirname(__FILE__) . '/CompositeView.php');
require_once(dirname(__FILE__) . '/../CradleCoreException.php');
require_once(dirname(__FILE__) . '/../utils/Validator.php');
require_once(dirname(__FILE__) . '/../utils/Utils.php');

require_once(dirname(__FILE__) . '/../../../third-parties/Mustache/Autoloader.php');

/**
 * Description of ViewRenderer
 *
 * @author alejandro.soto
 */
class ViewRenderer extends CompositeView implements IBaseView {


    /**
     *
     * @var array Current module configuration
     */
    private $configuration = null;
    
    /**
     * 
     * @var Mustache_Engine It generates the view to be rendered
     */
    private $mustacheEngine = null;
    
    /**
     * @var array $httpObject Is a main process unit where is stored current request data 
     */
    private $httpObject = null;
    
    /**
     * @var ControllerChildInstancer If a module has a child this object instance based on config
     */
    private $childInstancer = null;
	    
    public function __construct() {

    }

    /**
     * Sets the current configuration
     *
     * @param array $configuration Current controller configuration
     */
    public function setConfig($configuration) {
        $this->configuration = $configuration;
        Mustache_Autoloader::register();
        $this->mustacheEngine =  new Mustache_Engine(array('escape' => function($value) {return $value;}));
    }
    
    /**
     * Setter for childInstancer
     * 
     * @param ControllerChildInstancer $childInstancer
     * 
     */
    public function setChildInstancer($childInstancer) {
        $this->childInstancer = $childInstancer;
    }
    
    /**
     * Setter for httpObject
     * 
     * @param httpObject
     */
    public function setHttpObject($httpObject) {
        $this->httpObject = $httpObject;
        parent::setHttpObject($httpObject);
    }
    
    /**
     * Render the current action view if it exists
     * 
     * @param array $viewVars Variables to be passed to the view
     */
    public function renderView($viewVars) {
        $validView = Validator::isValidView($this->configuration->type, $this->configuration->action);
        if ($validView) {
            $template = Utils::fileToString($validView);
            /* Children modules(if it has) output key values for composite views*/
            $childrenViewOutput = $this->processChildrenModulesViews($viewVars, $template);
            echo($this->mustacheEngine->render($template, array_merge($viewVars, $childrenViewOutput)));
            return;
        }
        CradleCoreException::MVC('View ' . $this->configuration->action . '.view.php does not exist in ' .
                $this->configuration->type);
    }
    
    /**
     * Executes the children modules in order to retrieve each views and put it 
     * in the current view 
     *
     * @param array $viewVars Variables to be passed to the view
     * @param $template contains the text of the view template
     * 
     */
    private function processChildrenModulesViews($viewVars, $template) {
        $expectedModulesInstanceNames = $this->cleanDefinedVarTokens($viewVars, $this->retrieveAllDefinedVarTokens($template));  
        return $this->processCompositeChildren($expectedModulesInstanceNames, $this->configuration->action, $this->childInstancer);
	}
		
    
    /**
     * Matches all the tokens that are not specified in the done method 
     * from controller action
     * 
     * @param $template contains the text of the view template
     * @return Array with the tokens defined by the developer to be used in the view
     * 
     */
    private function retrieveAllDefinedVarTokens($template) {
        $tokens = $this->mustacheEngine->getTokenizer()->scan($template);
        $definedTokens = array();
        foreach ($tokens as $token) {
            if (isset($token['type']) && isset($token['name']) && $token['type'] == '_v') {
                $definedTokens[] = $token['name'];
            }
        }
        return $definedTokens;
    }

    /**
     * Discards the tokens that were defined in the controller to use only that ones that supposed to 
     * render children
     *  
     * @param array $viewVars Variables to be passed to the view
     * @param $definedTokens Tokens defined in t
     * 
     */
    private function cleanDefinedVarTokens($viewVars, $definedTokens) {
        $cleanedTokens = array();
        for ($i = 0; $i < count($definedTokens); $i++) {
            $existsInViewVars = false;
            foreach ($viewVars as $key => $val) {
                $existsInViewVars = (!$existsInViewVars && $definedTokens[$i] == $key) ? true : $existsInViewVars;
            }
            if (!$existsInViewVars) {
                $cleanedTokens[] = $definedTokens[$i];
            }
        }
        return $cleanedTokens;
    }
    
}

?>
