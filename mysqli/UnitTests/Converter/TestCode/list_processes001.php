--TEST--
SUCCESS: mysql_list_processes
--FILE--
<?php
/*
mysql_list_processes

(PHP 4 >= 4.3.0, PHP 5)
mysql_list_processes -- List MySQL processes
Description
resource mysql_list_processes ( [resource link_identifier] )

Retrieves the current MySQL server threads.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

A result pointer resource on success, or FALSE on failure.
Examples
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

if (!((bool)mysqli_query( $con, "USE $db")))
    printf("FAILURE: cannot select db '%s', [%d] %s\n",
        $db, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
   
if (!($res = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW PROCESSLIST")))
    printf("FAILURE: cannot run mysql_list_fields() on default connection, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

$row = mysqli_fetch_array($res);

if (!is_array($row))
    printf("FAILURE: expecting array, got %s value, [%d] %s\n", gettype($row), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
if (!array_key_exists("Id", $row) || !array_key_exists("User", $row) || !array_key_exists("Host", $row) ||    
    !array_key_exists("db", $row) || !array_key_exists("Command", $row) || !array_key_exists("Time", $row) ||
    !array_key_exists("State", $row) || !array_key_exists("Info", $row) || 
    !array_key_exists(0, $row) || !array_key_exists(1, $row) || !array_key_exists(2, $row) ||
    !array_key_exists(3, $row) || !array_key_exists(4, $row) || !array_key_exists(5, $row) ||
    !array_key_exists(6, $row) || !array_key_exists(7, $row) ||
    $row[0] != $row["Id"]) {
    printf("FAILURE: result hash does not have the expected entries, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
}    
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

if (!($res = mysqli_query($con, "SHOW PROCESSLIST")))
    printf("FAILURE: cannot run mysql_list_fields(), [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);    

$res = mysqli_query($illegal_link_identifier, "SHOW PROCESSLIST");
if (!is_null($res))
    printf("FAILURE: expecting null value, got %s value, [%d] %s\n", gettype($res), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($res)
    printf("FAILURE: expecting false, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
   
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
60, E_NOTICE, Undefined variable: illegal_link_identifier
60, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
25, 27, 27, 32, 56, 56,
--ENDOFTEST--