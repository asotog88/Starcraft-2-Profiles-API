<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/Utils.php');

/**
 * Description of DevicesManager
 *
 * @author alejandro
 */
class DevicesManager {

    /**
     *
     * @var array Represents all the valid devices to be searched in user agent
     */
    private $devicesObject;

    /**
     *
     * @param array $devicesObject Represents all the valid devices to be searched in user agent
     */
    public function __construct($devicesObject) {
        $this->devicesObject = isset($devicesObject) ? $devicesObject : array();
    }

    /**
     * Validates the devices user agents list against the request user agent
     *
     * @return string The device name or null if device do not match
     */
    public function getDevice() {
        foreach ($this->devicesObject as $deviceName => $userAgents) {
            for ($i = 0; $i < count($userAgents); $i++) {
                if (Utils::isUserAgentMatched($userAgents[$i])) {
                    return $deviceName;
                }
            }
        }
        return null;
    }

}
?>
