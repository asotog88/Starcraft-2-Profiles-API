<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/strings.php');
require_once(dirname(__FILE__) . '/templates/ProjectTemplate.php');
require_once(dirname(__FILE__) . '/templates/ModuleTemplate.php');

/**
 * Description of ProjectManager
 *
 * @author alejandro
 */
class ProjectManager {

    /**
     *
     * @var ProjectTemplate Generates the structure of a project
     */
    private $projectTemplate;

    /**
     *
     * @var ModuleTemplate Creates a new project/application module
     */
    private $moduleTemplate;

    public function  __construct() {
        $this->projectTemplate = new ProjectTemplate();
        $this->moduleTemplate = new ModuleTemplate();
    }

    /**
     * Creates a  new project
     *
     * @param string $projectName Project name
     *
     */
    public function createProject($projectName) {
        global $currentPath, $isProject, $texts;
        if (!$isProject) {
            $this->projectTemplate->createNewProject($projectName, $currentPath);
            return;
        }
        echo $texts['errorInsideProject'];
    }

    /**
     * Creates a new project/application module
     *
     * @param string $moduleName Is module name to be created
     */
    public function createModule($moduleName) {
        global $currentPath, $isProject, $texts;
        if ($isProject) {
            $this->moduleTemplate->createNewModule($currentPath, $moduleName);
            return;
        }
        echo $texts['errorModule'];
    }
}
?>
