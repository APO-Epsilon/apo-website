--TEST--
SUCCESS: mysql_connect with flags
--FILE--
<?php
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
--EXPECT-EXT/MYSQLI-PHP-ERRORS--
--EXPECT-CONVERTER-ERRORS--
5, 8, 11
--ENDOFTEST--