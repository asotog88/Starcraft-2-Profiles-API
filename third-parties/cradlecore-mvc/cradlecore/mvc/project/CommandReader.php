<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../utils/Utils.php');
require_once(dirname(__FILE__) . '/ProjectManager.php');
require_once(dirname(__FILE__) . '/strings.php');

/**
 * Description of CommandReader
 *
 * @author alejandro
 */
class CommandReader {

    /**
     *
     * @var ProjectManager Executes project operations, create project, modules, etc...
     */
    private $projectManager;

    public function __construct() {
        $this->projectManager = new ProjectManager();
    }

    /**
     * Reads the options task and arguments passed to the cradlecore command
     *
     * @param array $cliArguments Arguments passed with the cradlecore command
     */
    public function readCommand($cliArguments) {
        if (isset($cliArguments[1]) && isset($cliArguments[2]) && isset($cliArguments[3])) {
            $this->dispatchOption($cliArguments);
            return;
        }
        echo "\n" . Utils::fileToString(dirname(__FILE__) . '/help.txt');
    }

    /**
     * Dispatch option to valid option
     *
     * @param array $cliArguments Arguments passed with the cradlecore command
     */
    private function dispatchOption($cliArguments) {
        global $texts;
        switch ($cliArguments[1]) {
            case 'create':
                $this->dispatchTask($cliArguments);
                break;
            default:
                echo $texts['invalidCommand'];
                echo "\n" . Utils::fileToString(dirname(__FILE__) . '/help.txt');
                break;
        }
    }

    /**
     * Dispatch to a valid task
     *
     * @param array $cliArguments Arguments passed with the cradlecore command
     */
    private function dispatchTask($cliArguments) {
        global $texts;
        switch ($cliArguments[2]) {
            case 'project':
                $this->dispatchCommand($cliArguments[1], $cliArguments[2], $cliArguments[3]);
                break;
            case 'module':
                $this->dispatchCommand($cliArguments[1], $cliArguments[2], $cliArguments[3]);
                break;
            default:
                echo $texts['invalidCommand'];
                echo "\n" . Utils::fileToString(dirname(__FILE__) . '/help.txt');
                break;
        }
    }

    /**
     * Start the proccess
     *
     * @param string $option Command option
     * @param string $task Command task
     * @param string $argument Command argument
     */
    private function dispatchCommand($option, $task, $argument) {
        if ($option == 'create' && $task == 'project') {
            $this->projectManager->createProject($argument);
        } else if ($option == 'create' && $task == 'module') {
            $this->projectManager->createModule($argument);
        } else {
            echo $texts['invalidCommand'];
        }
    }

}
?>
