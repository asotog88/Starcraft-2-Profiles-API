<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/RequestDispatcher.php');
require_once(dirname(__FILE__) . '/../utils/Utils.php');

/**
 * Description of RequestMapper
 *
 * @author alejandro.soto
 */
class RequestMapper {

    /**
     *
     * @var array Is a main process unit where we store current request data
     */
    private $httpObject;

    /**
     *
     * @var array Encapsulates routes
     */
    private $routes;

    public function __construct() {
        
    }

    /**
     * Maps request to an specific configuration defined in application.json
     *
     * @param array $httpObject Is a main process unit where we store current request data
     */
    public function mapRequest($httpObject) {
        global $ROUTES;
        $this->httpObject = $httpObject;
        $this->routes = $ROUTES->url_mappings;
        $this->matchRoute();
    }

    /**
     * Matches the request in routes.json
     *
     */
    private function matchRoute() {
        foreach ($this->routes as $routeName => $route) {
            if ($this->isValidRoute($route)) {
                $route->name = $routeName;
                $requestDispatcher = new RequestDispatcher($this->httpObject, $route);
                return;
            }
        }
        $this->requestNotMapped();
    }

    /**
     * Checks if request was mapped
     * @param array $route Corresponds to a one of the routes defined in the routes.json
     * @return bool
     */
    private function isValidRoute($route) {
        return ($this->pathMatches($route->path) && $this->methodMatches($route->verbs));
    }

    /**
     * Checks path in routes
     * @param string $path Routes path
     * @return bool
     */
    private function pathMatches($path) {
        if ($this->httpObject['requestPath'] == $path) {
            return true;
        }
        return $this->hasUrlParams($path);
    }

    /**
     * Search in the path if it has params inside the url e.g : /fruit/melon or /fruit/apple
     *
     * @param string $path Routes path
     * @return bool
     */
    private function hasUrlParams($path) {
        $pathList = explode('/', $path);
        $requestPathList = explode('/', $this->httpObject['requestPath']);
        $urlParams = array();
        if ((count($pathList) == count($requestPathList)) && count($pathList) > 1) {
            for ($i = 1; $i < count($pathList); $i++) {
                if ($pathList[$i] != $requestPathList[$i]) {
                    if ($pathList[$i]) {
                        if (substr($pathList[$i], 0, 1) == ':') {
                            $urlParams[str_replace(':', '', $pathList[$i])] = $requestPathList[$i];
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            }
            $this->httpObject['routeParams'] = $urlParams;
            return true;
        }
        return false;
    }

    /**
     * Checks the request method
     * @param array $methods An array of methods to be used in this route
     * @return bool
     */
    private function methodMatches($methods) {
        if (in_array($this->httpObject['method'], $methods)) {
            return true;
        }
        return false;
    }

    /**
     * Throws HTTP 404 error when no route was defined for a request
     *
     */
    private function requestNotMapped() {
        error_reporting(0);
        header('HTTP/1.1 404 Not Found');
        error_reporting(E_ALL);
        echo Utils::fileToString(dirname(__FILE__) . '/../messages/pageNotFound.html');
    }

}

?>
