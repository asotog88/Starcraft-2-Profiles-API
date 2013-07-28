<?php 
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of IBaseView
 *
 * @author alejandro.soto
 */
interface IBaseView {
    
    /**
     * Render the current view if it exists
     * 
     * @param array $viewVars Variables to be passed to the view
     * 
     */
    public function renderView($viewVars);
    
    /**
     * Sets view configuration parameter
     *
     * @param array $configuration Current configuration
     */
    public function setConfig($configuration);
        
}
