<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../strings.php');
require_once(dirname(__FILE__) . '/../../utils/Utils.php');
require_once(dirname(__FILE__) . '/Template.php');

/**
 * Description of ProjectTemplate
 *
 * @author alejandro
 */
class ProjectTemplate extends Template {

    /**
     *
     * @var string Project Name
     */
    private $projectName;
    /**
     *
     * @var string Absolute project location
     */
    private $projectLocation;

    public function __construct() {

    }

    /**
     * Creates a new project
     *
     * @param string $projectName Project name
     * @param string $location Location where is going to be created the project
     */
    public function createNewProject($projectName, $location) {
        global $texts;
        $this->projectName = $projectName;
        $this->projectLocation = $location . '/' . $projectName;
        Utils::createDir($this->projectLocation);
        echo "\n" . $texts['genProjectFolder'];
        Utils::createDir($this->projectLocation . '/' . MODULES_FOLDER);
        echo "\n" . $texts['genModulesFolder'];
        Utils::createDir($this->projectLocation . '/' . CONFIGURATION_FOLDER);
        echo "\n" . $texts['genConfigFolder'];
        Utils::createDir($this->projectLocation . '/' . ASSETS_FOLDER);
        echo "\n" . $texts['genAssetsFolder'];
        $this->createApplicationConf($location, $projectName);
        $this->createRoutesConf($location, $projectName);
        $this->createDevicesConf($location, $projectName);
        $this->createIndexFile();
        $this->createHtaccess();
        echo "\n\n" . str_replace('{projectName}', $projectName, $texts['genProject']);
    }

    /**
     * Creates the application.json file based on template
     *
     */
    private function createApplicationConf($location, $projectName) {
        global $texts;
        $this->setTemplate(dirname(__FILE__) . '/application.template.json');
        $this->setValue('name', $this->projectName);
        $this->createFile($this->projectLocation . '/' . CONFIGURATION_FOLDER . '/' . APPLICATION_FILE);
        echo "\n" . $texts['genAppJson'];
    }

    /**
     * Creates the routes.json file based on template
     *
     */
    private function createRoutesConf($location, $projectName) {
        global $texts;
        $this->setTemplate(dirname(__FILE__) . '/routes.template.json');
        $this->setValue('entryPoint', $projectName);
        $this->createFile($this->projectLocation . '/' . CONFIGURATION_FOLDER . '/' . ROUTES_FILE);
        echo "\n" . $texts['genRoutesJson'];
    }

     /**
     * Creates the devices.json file based on template
     *
     */
    private function createDevicesConf($location, $projectName) {
        global $texts;
        $this->setTemplate(dirname(__FILE__) . '/devices.template.json');
        $this->createFile($this->projectLocation . '/' . CONFIGURATION_FOLDER . '/' . DEVICES_FILE);
        echo "\n" . $texts['genDevicesJson'];
    }

    /**
     * Creates the index file
     *
     * @global array $texts Texts for output
     * @global string $cradlecorePath Path to cradlecore libraries
     */
    private function createIndexFile() {
        global $texts, $cradlecorePath;
        $this->setTemplate(dirname(__FILE__) . '/index.template.php');
        $this->setValue('cradlecorePath', $cradlecorePath);
        $this->createFile($this->projectLocation . '/' . INDEX_FILE);
        echo "\n" . $texts['genIndex'];
    }

    /**
     * Generates 2 ( .htaccess and htaccess.txt for ms windows ) htaccess files for url rewriting
     * 
     */
    private function createHtaccess() {
        global $texts;
        $this->setTemplate(dirname(__FILE__) . '/template.htaccess');
        $this->createFile($this->projectLocation . '/' . HTACCESS_FILE);
        $this->createFile($this->projectLocation . '/' . HTACCESSTXT_FILE);
        $this->setTemplate(dirname(__FILE__) . '/configuration.template.htaccess');
        $this->createFile($this->projectLocation . '/' . CONFIGURATION_FOLDER . '/' . HTACCESS_FILE);
        $this->createFile($this->projectLocation . '/' . CONFIGURATION_FOLDER . '/' . HTACCESSTXT_FILE);
        echo "\n" . $texts['genHtaccess'];
    }

}
?>
