<?php
$APP_DIRECTORY = dirname(__FILE__);

/* include framework files, for deploy installation set this path to the Autoloader.php  */
require_once('{cradlecorePath}/lib/cradlecore/mvc/Autoloader.php');

/* starts to initialize mvc and request processing  */
$autoloader = new Autoloader();
?>

