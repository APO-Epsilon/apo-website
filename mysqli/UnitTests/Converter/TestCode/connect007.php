--TEST--
SUCCESS: mysql_connect() with Unix Socket
--FILE--
<?php
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost", NULL, NULL, NULL, 0, 'path/to/socket/'));
var_dump(is_resource($con));
var_dump(((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res));
?>
--EXPECT-EXT/MYSQL-OUTPUT--
bool(false)
bool(false)

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
bool(false)
bool(false)

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
5, E_WARNING, mysqli_connect()
7, E_WARNING, mysqli_close()
--EXPECT-CONVERTER-ERRORS--
6,
--ENDOFTEST--