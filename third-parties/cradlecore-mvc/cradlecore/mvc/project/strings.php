<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$texts = array(
    'title' => 'Cradlecore MVC Framework',
    'errorInsideProject' => 'Problem: Project cannot be created you are inside a project.',
    'invalidCommand' => 'Problem: Command does not exists.',
    'genProjectFolder' => 'Project folder generated',
    'genModulesFolder' => 'Modules folder generated',
    'genConfigFolder' => 'Configuration folder generated',
    'genAssetsFolder' => 'Assets folder generated',
    'genAppJson' => 'application.json configuration generated',
    'genRoutesJson' => 'routes.json url mapping file generated',
    'genDevicesJson' => 'mobile devices.json file generated',
    'genIndex' => 'application index.php file generated',
    'genHtaccess' => 'htaccess files and rewrite rules generated',
    'genProject' => 'Project {projectName} has been generated successfully!!!',
    'errorModule' => 'Problem: Module can not be created no project in this path.',
    'genModuleFolder' => 'Module folder generated',
    'genModelsFolder' => 'Models folder generated',
    'genViewsFolder' => 'Views folder generated',
    'genController' => 'Controller file generated',
    'genModel' => 'Model file generated',
    'genView' => 'View file generated',
    'genModule' => 'Module {moduleName} has been generated successfully!!!'
);

/**
 * Directories and filenames
 */
define('MODULES_FOLDER', 'modules');
define('CONFIGURATION_FOLDER', 'configuration');
define('ASSETS_FOLDER', 'assets');
define('MODELS_FOLDER', 'models');
define('VIEWS_FOLDER', 'views');

define('APPLICATION_FILE', 'application.json');
define('DEVICES_FILE', 'devices.json');
define('ROUTES_FILE', 'routes.json');
define('INDEX_FILE', 'index.php');
define('HTACCESS_FILE', '.htaccess');
define('HTACCESSTXT_FILE', 'htaccess.txt');
define('CONTROLLER_FILE', 'controller.php');
define('MODEL_FILE', 'model.php');
define('VIEW_FILE', 'index.view.php');

?>
