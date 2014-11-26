--TEST--
SUCCESS: mysql_stat()
--FILE--
<?php
/*
mysql_stat

(PHP 4 >= 4.3.0, PHP 5)
mysql_stat -- Get current system status
Description
string mysql_stat ( [resource link_identifier] )

mysql_stat() returns the current server status.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns a string with the status for uptime, threads, queries, open tables, flush tables and queries per second. For a complete list of other status variables, you have to use the SHOW STATUS SQL command. If link_identifier is invalid, NULL is returned. 

NOTE: DOCUMENTATION IS WRONG - returns NULL instead of FALSE
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

if (!((bool)mysqli_query( $con, "USE $db")))
    printf("FAILURE: [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    
$stat_default   = mysqli_stat($GLOBALS["___mysqli_ston"]);
$stat_con       = mysqli_stat($con);
if ('' == $stat_default || '' == $stat_con)
    printf("FAILURE: got empty strings for mysql_stat()\n");

if (!is_string($stat_con))
    printf("FAILURE: string value expected, got %s value\n", gettype($stat_con));

$stat_con = mysqli_stat($illegal_link_identifier);
if (!is_null($stat_con))
    printf("FAILURE: NULL value expected because of illegal identifier, got %s value\n", gettype($stat_con));

if ($stat_con)
    printf("FAILURE: false expected\n");
    
    
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
45, E_NOTICE, Undefined variable: illegal_link_identifier
45, E_WARNING, mysqli_stat() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
26, 28, 28, 33,
--ENDOFTEST--