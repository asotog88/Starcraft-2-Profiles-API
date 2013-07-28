<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../../utils/Utils.php');

/**
 * Description of Template
 *
 * @author alejandro
 */
class Template {

    private $template;
    private $output;

    public function __construct() {

    }

    /**
     * Sets path to template and retrieve the file
     *
     * @param string $template Path to template
     */
    public function setTemplate($template) {
        $this->template = $template;
        $this->output = Utils::fileToString($template);
    }

    /**
     * Sets a template value
     *
     * @param string $key Key to be matched and set
     * @param string $value Value to be set
     */
    public function setValue($key, $value) {
        $this->output = str_replace('{' . $key . '}', $value, $this->output);
    }

    /*
     * Creates the output file
     *
     */

    public function createFile($file) {
        $Handle = fopen($file, 'w');
        fwrite($Handle, $this->output);
        fclose($Handle);
    }

}
?>
