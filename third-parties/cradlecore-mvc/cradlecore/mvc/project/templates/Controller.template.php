<?php

/**
 * Description of {moduleName}Controller
 *
 * @author alejandro.soto
 */
class {moduleName}Controller extends CradleCoreController {

    public function __construct() {

    }

    /**
     * Index action method
     *
     */
    public function index() {
        $data = $this->model->getData();
        $this->done(array('name' => 'Someone', 'somedata' => $data));
    }

}

?>
