<?php 
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of IBaseController
 *
 * @author alejandro.soto
 */
interface IBaseController {
    
    /**
     * Render the current view if it exists
     * 
     * @param array $viewVars Variables to be passed to the view
     * 
     */
    public function done($viewVars);
    
    /**
     * Set the current model
     *
     * @param object $model An object with models associated
     */
    public function setModel($viewVars);
    
    /**
     * Sets the current configuration
     *
     * @param array $configuration Current controller configuration
     */
    public function setConfiguration($viewVars);
    
    /**
     * Function used from the view to retrieve the values set in the controller
     *
     * @param string $key The key of the var value to be returned
     * @return var 
     */
    public function get($viewVars);
    
        
}
