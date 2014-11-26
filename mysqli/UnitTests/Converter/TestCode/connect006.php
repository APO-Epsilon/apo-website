--TEST--
SUCCESS: mysql_connect() with Unix Socket - ext/mysql reports success for bogus socket
--FILE--
<?php
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost",  $user,  $pass, NULL, 0, 'path/to/socket/'));
var_dump(is_resource($con));
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
bool(true)

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
bool(false)

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
--EXPECT-CONVERTER-ERRORS--
6,
--ENDOFTEST--