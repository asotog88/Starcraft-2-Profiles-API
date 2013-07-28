<?php
/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/strings.php');
require_once(dirname(__FILE__) . '/CommandReader.php');
echo $texts['title'] . "\n";
$command = new CommandReader();
$command->readCommand($argv);
?>
