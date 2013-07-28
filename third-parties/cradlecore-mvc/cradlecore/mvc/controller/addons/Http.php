<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of Http
 *
 * @author alejandro.soto
 */
class Http {

    /**
     *
     * @var array Is a main process unit where we store current request data
     */
    private $httpObject;

    public function __construct() {

    }

    /**
     * Setter for http object
     *
     * @param $array $httpObject Http object setter
     */
    public function setHttpObject($httpObject) {
        $this->httpObject = $httpObject;
    }

    /**
     * 
     * Getter for httpObject
     * 
     * @return httpObject
     */
    public function getHttpObject() {
        return $this->httpObject;
    }

    /**
     * Formats a path into a full url, for example when referencing a static file inside the application
     *
     * @param string $path Path to an application file, asset, only path, etc
     * @return string full url to the application path or file path
     */
    public function url($path) {
        return $this->httpObject['entryPoint'] . $path;
    }

    /**
     * Sets a response header
     *
     * @param string $header Http header
     */
    public function setHeader($header) {
        error_reporting(0);
        header($header);
        error_reporting(E_ALL);
    }

    /**
     * 
     * Getter for headers
     * @return Http headers
     */
    public function getHeaders() {
        return $this->httpObject['headers'];
    }

    /**
     *
     * Redirects to another url
     * @param string $location Location where is going to be redirected
     */
    public function redirect($location) {
        error_reporting(0);
        header('Location: ' . $location);
        error_reporting(E_ALL);
    }

}
?>
