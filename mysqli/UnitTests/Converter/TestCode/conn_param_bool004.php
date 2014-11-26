--TEST--
SUCCESS: mysql_get_server_info()
--FILE--
<?php
/*
mysql_get_server_info

(PHP 4 >= 4.0.5, PHP 5)
mysql_get_server_info -- Get MySQL server info
Description
string mysql_get_server_info ( [resource link_identifier] )

Retrieves the MySQL server version.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns the MySQL server version on success, or FALSE on failure. 
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

$server_info_default  = ((is_null($___mysqli_res = mysqli_get_server_info($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
$server_info_con      = ((is_null($___mysqli_res = mysqli_get_server_info($con))) ? false : $___mysqli_res);
if ($server_info_con != $server_info_default) {
    printf("FAILURE: proto info of default connection and specified connection differ\n");
}

if (!is_string($server_info_con))
    printf("FAILURE: function should have returned a string\n");

$server_info_con = ((is_null($___mysqli_res = mysqli_get_server_info($illegal_link_identifier))) ? false : $___mysqli_res);
if (!is_bool($server_info_con))
    printf("FAILURE: function should have returned a boolean value, got %s value\n", gettype($server_info_con));

if ($server_info_con)
    printf("FAILURE: function should have failed with illegal link identifier\n");
    
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
40, E_NOTICE, Undefined variable: illegal_link_identifier
40, E_WARNING, mysqli_get_server_info() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
24, 26, 26,
--ENDOFTEST--