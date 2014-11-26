--TEST--
SUCCESS: mysql_insert_id()
--FILE--
<?php
/*
mysql_insert_id

(PHP 3, PHP 4, PHP 5)
mysql_insert_id -- Get the ID generated from the previous INSERT operation
Description
int mysql_insert_id ( [resource link_identifier] )

Retrieves the ID generated for an AUTO_INCREMENT column by the previous INSERT query.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

The ID generated for an AUTO_INCREMENT column by the previous INSERT query on success, 0 if the previous query does not generate an AUTO_INCREMENT value, or FALSE if no MySQL connection was established.
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

if (!mysqli_query( $con, "DELETE FROM nobody"))
    printf("FAILURE: Cannot delete records, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if (!mysqli_query( $con, 'INSERT INTO nobody(id, msg) VALUES (1, "mysql_insert_id()")'))
    printf("FAILURE: Cannot insert, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$id_default = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
$id_con     = ((is_null($___mysqli_res = mysqli_insert_id($con))) ? false : $___mysqli_res);

if ($id_default != $id_con)
    printf("FAILURE: Different values for default and specified connection\n");
    
if (!is_int($id_con))
    printf("FAILURE: Function should have returned an integer value, got %s value\n", gettype($id_con));
        
if ($id_con !== 0)
    printf("FAILURE: Expecting 0, because table has no auto_increment column, got %d\n", $id_con);
    
$id_con = ((is_null($___mysqli_res = mysqli_insert_id($illegal_link_identifier))) ? false : $___mysqli_res);
if (!is_bool($id_con))
    printf("FAILURE: mysql_insert_id(<illegal_link_identifier>) should have returned a boolean value, got %s value\n", gettype($id_con));
    
if ($id_con !== false)
    printf("FAILURE: Function should have returned false\n");    
    
if (!mysqli_query( $con, "DELETE FROM root"))
    printf("FAILURE: Cannot delete records from root, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if (!mysqli_query( $con, 'INSERT INTO root(msg) VALUES ("mysql_insert_id()")'))
    printf("FAILURE: Cannot insert, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$id_con     = ((is_null($___mysqli_res = mysqli_insert_id($con))) ? false : $___mysqli_res);
if (!is_int($id_con))
    printf("FAILURE: Function should have returned an integer value for auto_increment column, got %s value\n", gettype($id_con));
    
if ($id_con < 1)
    printf("FAILURE: Function returned bogus value for auto_increment column\n");        

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
52, E_NOTICE, Undefined variable: illegal_link_identifier
52, E_WARNING, mysqli_insert_id() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
24, 26, 26, 31,
--ENDOFTEST--