<?php

define('DB_HOST', 'apo.cxav86kuligx.us-west-2.rds.amazonaws.com');
define('DB_NAME', 'apo');
define('DB_USER','apo');
define('DB_PASSWORD','alphaphiomega');

$db=($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD)) or die("Failed to connect to MySQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$er=((bool)mysqli_query($db, "USE " . constant('DB_NAME'))) or die("Failed to connect to MySQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

?>