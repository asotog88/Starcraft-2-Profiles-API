<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/RequestMapper.php');
require_once(dirname(__FILE__) . '/../utils/Utils.php');

/**
 * Description of RequestListener
 *
 * @author alejandro.soto
 */
class RequestListener extends RequestMapper {

    /**
     *
     * @var array Is a main process unit where we store current request data
     */
    private $httpObject = null;

    public function __construct() {
        $this->httpObject = array(
            /* full url path */
            'path' => $_SERVER['REQUEST_URI'],
            /* request method */
            'method' => strtolower($_SERVER['REQUEST_METHOD']),
            'query_string' => $_SERVER['QUERY_STRING'],
            /* root entry point of requests */
            'entryPoint' => '',
            /* path from entry point to end of url path */
            'requestPath' => '',
            'params' => array(),
            'headers' => array(),
            'routeParams' => array()
        );
        $this->processPath();
    }

    /**
     * Starts to process the requested path
     *
     */
    private function processPath() {
        $this->getEntryPointFromUrl();
        $this->getRequestPathFromUrl();
        $this->httpObject['headers'] = $this->getHeadersFromRequest();
        $this->httpObject['params'] = $this->getParamsFromRequest();
        $this->mapRequest($this->httpObject);
    }
    /**
     * Retrieve the entry point relative to entry point defined in the application json
     *
     */
    private function getEntryPointFromUrl() {
        global $ROUTES;
        $this->httpObject['entryPoint'] = $ROUTES->entry_point;
        $this->httpObject['entryPoint'] = (trim($this->httpObject['entryPoint']) == '') ? '' : substr($this->httpObject['path'], 0, strpos($this->httpObject['path'], $this->httpObject['entryPoint']) + strlen($this->httpObject['entryPoint']) - 1);
    }

    /**
     * Gets only the request path from the entry point and
     * removes the query string if exists
     * 
     */
    private function getRequestPathFromUrl() {
        $this->httpObject['requestPath'] = str_replace($this->httpObject['entryPoint'], '', $this->httpObject['path']);
        $this->httpObject['requestPath'] = str_replace('?' . $this->httpObject['query_string'], '', $this->httpObject['requestPath']);
    }

    /**
     * Retrieve headers from request
     *
     * @return array Headers
     */
    private function getHeadersFromRequest() {
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$name] = $value;
            } else if ($name == "CONTENT_TYPE") {
                $headers["Content-Type"] = $value;
            } else if ($name == "CONTENT_LENGTH") {
                $headers["Content-Length"] = $value;
            }
        }
        return $headers;
    }

    /**
     * Retrieve params sent in the request
     * @return array Associative array with params
     */
    private function getParamsFromRequest() {
        $params = array();
        switch ($this->httpObject['method']) {
            case 'get':
                $params = $_GET;
                break;
            case 'post':
                $params = $_POST;
        }
        return $params;
    }

}

?>
