--TEST--
SUCCESS: mysql_thread_id()
--FILE--
<?php
/*
mysql_thread_id

(PHP 4 >= 4.3.0, PHP 5)
mysql_thread_id -- Return the current thread ID
Description
int mysql_thread_id ( [resource link_identifier] )

Retrieves the current thread ID. If the connection is lost, and a reconnect with mysql_ping() is executed, the thread ID will change. This means only retrieve the thread ID when needed.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

The thread ID on success, or FALSE on failure.


NOTE: DOCUMENTATION IS WRONG - NULL on failure!
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

    
$id_default = mysqli_thread_id($GLOBALS["___mysqli_ston"]);
$id_con     = mysqli_thread_id($con);

if ($id_default != $id_con)
    printf("FAILURE: Different values for default and specified connection\n");

if (!is_int($id_con))
    printf("FAILURE: Function should have returned an integer value, got %s value\n", gettype($id_con));
        
$id_con = mysqli_thread_id($illegal_link_identifier) ;
if (!is_null($id_con))
    printf("FAILURE: Function should have returned a NULL value, got %s value\n", gettype($id_con)); 
   
if ($id_con !== NULL)
    printf("FAILURE: Should return NULL because of illegal link identifier\n");   

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
47, E_NOTICE, Undefined variable: illegal_link_identifier
47, E_WARNING, mysqli_thread_id() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
27, 29, 29, 34,
--ENDOFTEST--