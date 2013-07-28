<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../../utils/DevicesManager.php');

/**
 * Description of Device
 *
 * @author alejandro
 */
class Device {

    /**
     *
     * @var DevicesManager Checks an specific device user agent in user agent
     */
    private $devicesManager;

    public function  __construct() {
        global $DEVICES;
        $this->devicesManager = new DevicesManager($DEVICES);
    }

    /**
     * Retrieve the device name
     *
     * @return string Device name or null if is not a valid mobile device
     */
    public function getDeviceName() {
        return $this->devicesManager->getDevice();
    }

    /**
     * Validates if the request is from valid device
     *
     * @return boolean True if is a valid mobile device
     */
    public function isDevice() {
        return ($this->devicesManager->getDevice() != null);
    }

}
?>
