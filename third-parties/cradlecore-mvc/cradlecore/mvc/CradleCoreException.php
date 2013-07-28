<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of CradleCoreException
 *
 * @author alejandro.soto
 */
class CradleCoreException {
    //put your code here

    public static function MVC($message) {
        $title = 'CradleCoreException';
        if (php_sapi_name() != 'cli') {
            $title = '<b>' . $title . '</b>';
        }
        echo "\n" . $title  .": " . $message . "\n";
    }
}
?>
