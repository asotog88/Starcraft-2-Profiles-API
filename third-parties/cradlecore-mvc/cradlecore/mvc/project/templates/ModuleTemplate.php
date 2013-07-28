<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/Template.php');
require_once(dirname(__FILE__) . '/../../utils/Utils.php');
require_once(dirname(__FILE__) . '/../strings.php');

/**
 * Description of ModuleTemplate
 *
 * @author alejandro
 */
class ModuleTemplate extends Template {

    /**
     *
     * @var string Module Name
     */
    private $moduleName;
    /**
     *
     * @var string Absolute module location
     */
    private $moduleLocation;

    public function __contruct() {
        
    }

    /**
     * Creates a new project/$locationapplication module based on templates
     *
     * @param string $location Project location
     * @param string $moduleName Module name to be created
     */
    public function createNewModule($location, $moduleName) {
        global $texts;
        $this->moduleName = $moduleName;
        $this->moduleLocation = $location . '/' . MODULES_FOLDER . '/' . $moduleName;
        Utils::createDir($this->moduleLocation);
        echo "\n" . $texts['genModuleFolder'];
        Utils::createDir($this->moduleLocation . '/' . ASSETS_FOLDER);
        echo "\n" . $texts['genAssetsFolder'];
        Utils::createDir($this->moduleLocation . '/' . MODELS_FOLDER);
        echo "\n" . $texts['genModelsFolder'];
        Utils::createDir($this->moduleLocation . '/' . VIEWS_FOLDER);
        echo "\n" . $texts['genViewsFolder'];
        $this->createControllerFile();
        $this->createModelFile();
        $this->createViewFile();
        echo "\n\n" . str_replace('{moduleName}', $moduleName, $texts['genModule']);
    }

    /**
     * Creates the controller file for the module
     * 
     * @global array $texts Contains text for output
     */
    private function createControllerFile() {
        global $texts;
        $this->setTemplate(dirname(__FILE__) . '/Controller.template.php');
        $this->setValue('moduleName', $this->moduleName);
        $this->createFile($this->moduleLocation . '/' . CONTROLLER_FILE);
        echo "\n" . $texts['genController'];
    }

    /**
     * Creates  the model file for the module
     *
     * @global array $texts Contains text for output
     */
    private function createModelFile() {
        global $texts;
        $this->setTemplate(dirname(__FILE__) . '/Model.template.php');
        $this->setValue('moduleName', $this->moduleName);
        $this->createFile($this->moduleLocation . '/' . MODELS_FOLDER . '/' . MODEL_FILE);
        echo "\n" . $texts['genModel'];
    }

    /**
     * Creates a view for the module
     *
     * @global array $texts Contains text for output
     */
    private function createViewFile() {
        global $texts;
        $this->setTemplate(dirname(__FILE__) . '/index.view.template.php');
        $this->setValue('moduleName', $this->moduleName);
        $this->createFile($this->moduleLocation . '/' . VIEWS_FOLDER . '/' . VIEW_FILE);
        echo "\n" . $texts['genView'];
    }

}
?>
