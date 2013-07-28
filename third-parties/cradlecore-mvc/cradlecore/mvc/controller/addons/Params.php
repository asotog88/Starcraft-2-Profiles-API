<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of Params
 *
 * @author alejandro.soto
 */
class Params {

    /**
     *
     * @var array Route params passed in the url path
     */
    private $routeParams;
    /**
     *
     * @var array Params passed in the query string or in the body of post request
     */
    private $params;

    public function __construct() {
        
    }
    

    /**
     * Setter for local properties
     *
     * @param array $routeParams Route params passed in the url path
     * @param array $params Params passed in the query string or in the body of post request
     */
    public function setParams($routeParams, $params) {
        $this->params = $params;
        $this->routeParams = $routeParams;
    }

    /**
     * Retrieve params from query string or  body
     *
     * @param string  $key Key used to retrieve param
     */
    public function getParam($key) {
        return (isset ($this->params[$key])) ? $this->params[$key] : null;
    }

    /**
     * Retrieve params from request path
     *
     * @param  string  $key Key used to retrieve param
     */
    public function getParamFromUrl($key) {
        return (isset ($this->routeParams[$key])) ? $this->routeParams[$key] : null;
    }

}

?>
