<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/Utils.php');
require_once(dirname(__FILE__) . '/DevicesManager.php');
require_once(dirname(__FILE__) . '/../CradleCoreException.php');

/**
 * Description of Validator
 *
 * @author alejandro.soto
 */
class Validator {

    /**
     * Validates a module
     *
     * @param array $configuration Module configuration
     * @param string $action Controller action
     * @return bool
     */
    public static function validateModule($configuration, $action) {
        if (isset($configuration->type) && Validator::isValidModule($configuration->type, $action)) {
            return Validator::isValidController($configuration->type, $action);
        }
        return false;
    }

    /**
     * Validates if module  and controller method exists
     *
     * @param string $module Module name
     * @param string $action    Controller action name
     * @return bool
     */
    public static function isValidModule($module) {
        global $APP_DIRECTORY;
        $modulePath = $APP_DIRECTORY . '/modules/' . $module;
        $controllerPath = $modulePath . '/controller.php';
        if (file_exists($controllerPath) && file_exists($modulePath)) {
            require_once($controllerPath);
            return true;
        }
        return false;
    }

    /**
     * Validates if module model exists
     *
     * @param string $module Module name
     * @return bool
     */
    public static function isValidModuleModel($module) {
        global $APP_DIRECTORY;
        $modulePath = $APP_DIRECTORY . '/modules/' . $module;
        $modelPath = $modulePath . '/models/model.php';
        $modelName = $module . 'Model';
        $validModel = false;
        if (file_exists($modelPath)) {
            require_once($modelPath);
            $validModel = (class_exists($modelName));
        }
        if (!$validModel) {
            CradleCoreException::MVC('Model ' . $modelName . ' is not defined.');
        }
        return $validModel;
    }

    /**
     *  Validates if controller and action are valids
     *
     * @param string $module Module name
     * @param string $action Controller action name
     * @return bool
     */
    public static function isValidController($module, $action) {
        $controllerName = $module . 'Controller';
        if (class_exists($controllerName) && method_exists($controllerName, $action)) {
            return true;
        }
        CradleCoreException::MVC('Controller class ' . $controllerName .
                ' is missing something or action method ' . $action . ' does not exists.');
        return false;
    }

    /**
     * Validates if a view for current action method exists
     *
     * @param string $module Module name
     * @param string $action Controller action name
     * @return string View full path
     */
    public static function isValidView($module, $action) {
        global $DEVICES, $APP_DIRECTORY;
        $modulePath = $APP_DIRECTORY . '/modules/' . $module;
        $devicesManager = new DevicesManager($DEVICES);
        $device = $devicesManager->getDevice() ? '.' . $devicesManager->getDevice() : '';
        $defaultViewPath = $modulePath . '/views/' . $action . '.view.php';
        $viewPath = $modulePath . '/views/' . $action . $device . '.view.php';
        if (file_exists($viewPath)) {
            return $viewPath;
        }
        return file_exists($defaultViewPath) ? $defaultViewPath : null;
    }

    /**
     *  Validate if a frame exists
     *
     * @param string $frame Frame name configured in application.json
     * @return string frame full path
     *
     */
    public static function isValidFrame($frame) {
        $framePath = dirname(__FILE__) . '/../frames/' . $frame . '.frame.php';
        if (file_exists($framePath)) {
            return $framePath;
        }
        return null;
    }

}

?>
