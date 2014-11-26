--TEST--
FAILURE: mysql_query
--FILE--
<?php
/*
mysql_query

(PHP 3, PHP 4, PHP 5)
mysql_query -- Send a MySQL query
Description
resource mysql_query ( string query [, resource link_identifier] )

mysql_query() sends a query (to the currently active database on the server that's associated with the specified link_identifier).
Parameters

query

    A SQL query

    The query string should not end with a semicolon. 
link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

For SELECT, SHOW, DESCRIBE or EXPLAIN statements, mysql_query() returns a resource on success, or FALSE on error.

For other type of SQL statements, UPDATE, DELETE, DROP, etc, mysql_query() returns TRUE on success or FALSE on error.

The returned result resource should be passed to mysql_fetch_array(), and other functions for dealing with result tables, to access the returned data.

Use mysql_num_rows() to find out how many rows were returned for a SELECT statement or mysql_affected_rows() to find out how many rows were affected by a DELETE, INSERT, REPLACE, or UPDATE statement.

mysql_query() will also fail and return FALSE if the user does not have permission to access the table(s) referenced by the query. 
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
        
$res = mysqli_query( $con, "DELETE FROM nobody");
if (!is_bool($res))
    printf("FAILURE: expecting boolean value as a reply to DELETE, got %s value, [%d] %s\n", gettype($res),
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if (!$res)
    printf("FAILURE: expecting true as a reply to DELETE, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$res = mysqli_query( $con, "INSERT INTO nobody(id, msg) VALUES (1, 'one')");    
if (!is_bool($res))
    printf("FAILURE: expecting boolean value as a reply to INSERT, got %s value, [%d] %s\n", gettype($res),
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if (!$res)
    printf("FAILURE: expecting true as a reply to INSERT, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

$res = mysqli_query( $con, "SELECT id, msg FROM nobody");
if (!is_resource($res))
    printf("FAILURE: known change, mysql_query() returns resource, mysqli_query returns object\n");

if (!$res)
    printf("FAILURE: expecting true as a reply to SELECT, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$row = mysqli_fetch_assoc($res);
if (!is_array($row) || !$row)
    printf("FAILURE: could not fetch record, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($row['id'] != 1)
    printf("FAILURE: strange result, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, msg FROM nobody");
if (!is_resource($res))
    printf("FAILURE: known change, mysql_query() returns resource (default connection), mysqli_query returns object\n");

if (!$res)
    printf("FAILURE: expecting true as a reply to SELECT (default connection), [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

$res = mysqli_query( $con, "SELECT id, msg FROM table_which_does_not_exist");
if (!is_bool($res))
    printf("FAILURE: known change, mysql_query() returns false on error (unknown table), mysqli_query returns NULL\n");

if ($res)
    printf("FAILURE: expecting false as a reply to SELECT (unknown table), [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

$res = mysqli_query( $illegal_link_identifier, "SELECT id, msg FROM nobody");
if (!is_bool($res))
    printf("FAILURE: known change, mysql_query() returns false on error (illegal link identifier), mysqli_query returns NULL\n");

if ($res)
    printf("FAILURE: expecting false as a reply to SELECT (illegal link identifier), [%d] %s\n", ((is_object($illegal_link_identifier)) ? mysqli_errno($illegal_link_identifier) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($illegal_link_identifier)) ? mysqli_error($illegal_link_identifier) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  
$res = mysqli_query( $con, "SHOW TABLES");
if (!is_resource($res))
    printf("FAILURE: known change, mysql_query() returns resource (SHOW TABLES), mysqli_query returns object\n");

if (!$res)
    printf("FAILURE: expecting true as a reply to SHOW TABLES, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

$res = mysqli_query( $con, "DESCRIBE nobody");
if (!is_resource($res))
    printf("FAILURE: known change, mysql_query() returns resource (DESCRIBE), mysqli_query returns object\n");

if (!$res)
    printf("FAILURE: expecting true as a reply to DESCRIBE, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

$res = mysqli_query( $con, "EXPLAIN SELECT id FROM nobody");
if (!is_resource($res))
    printf("FAILURE: known change, mysql_query() returns resource (EXPLAIN), mysqli_query returns object\n");

if (!$res)
    printf("FAILURE: expecting true as a reply to EXPLAIN, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);



((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect
FAILURE: known change, mysql_query() returns resource, mysqli_query returns object
FAILURE: known change, mysql_query() returns resource (default connection), mysqli_query returns object
FAILURE: known change, mysql_query() returns false on error (illegal link identifier), mysqli_query returns NULL
FAILURE: known change, mysql_query() returns resource (SHOW TABLES), mysqli_query returns object
FAILURE: known change, mysql_query() returns resource (DESCRIBE), mysqli_query returns object
FAILURE: known change, mysql_query() returns resource (EXPLAIN), mysqli_query returns object

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
96, E_NOTICE, Undefined variable: illegal_link_identifier
96, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
37, 39, 39, 44, 65, 81, 85, 85, 104, 113, 122,
--ENDOFTEST--