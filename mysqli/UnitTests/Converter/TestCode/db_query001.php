--TEST--
SUCCESS: mysql_db_query()
--FILE--
<?php
/*
mysql_db_query

(PHP 3, PHP 4, PHP 5)
mysql_db_query -- Send a MySQL query
Description
resource mysql_db_query ( string database, string query [, resource link_identifier] )

mysql_db_query() selects a database, and executes a query on it.
Parameters

database

    The name of the database that will be selected. 
query

    The MySQL query. 
link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns a positive MySQL result resource to the query result, or FALSE on error. The function also returns TRUE/FALSE for INSERT/UPDATE/DELETE queries to indicate success/failure. 
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

if (function_exists('mysqli_query')) {   

    $res = ((mysqli_query($GLOBALS["___mysqli_ston"], "USE $db")) ? mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT DATABASE() AS db") : false);
    if (!$res)
        printf("FAILURE: Cannot run query on default connection, [%d] %s\n", 
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    // mysqli resource is an object 
    if (!is_resource($res) && !is_bool($res) && !is_object($res))
        printf("FAILURE: Function is expected to return resource or boolean value, using default connection, got %s, [%d] %s\n",
           gettype($res), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))); 
           
    $row = mysqli_fetch_assoc($res);
    if ($row['db'] != $db)
        printf("FAILURE: Got connected to %s, expected %s using default connection, [%d] %s\n",
            $row['db'], $db, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))); 
    
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
                       
    $res = ((mysqli_query( $con, "USE $db")) ? mysqli_query( $con,  "SELECT DATABASE() AS db") : false);
    if (!$res)
        printf("FAILURE: Cannot run query, [%d] %s\n", 
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    
    if (!is_resource($res) && !is_bool($res) && !is_object($res))
        printf("FAILURE: Function is expected to return resource or boolean value, got %s, [%d] %s\n",
           gettype($res), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))); 

    $row = mysqli_fetch_assoc($res);
    if ($row['db'] != $db)
        printf("FAILURE: Got connected to %s, expected %s, [%d] %s\n",
            $row['db'], $db, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));            
    
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);       
    
    $res = ((mysqli_query( $illegal_link_identifier, "USE $db")) ? mysqli_query( $illegal_link_identifier,  "SELECT DATABASE() AS db") : false);
        
    if (!is_resource($res) && !is_bool($res) && !is_object($res))
        printf("FAILURE: Function is expected to return resource or boolean value, illegal link identifier, got %s, [%d] %s\n",
           gettype($res), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))); 

    if ($res)
        printf("FAILURE: Function is expected to return false, illegal link identifier, [%d] %s\n",
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false))); 
    
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);       
}

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
73, E_NOTICE, Undefined variable: illegal_link_identifier
73, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
83, E_WARNING, mysqli_free_result() expects parameter 1 to be mysqli_result, boolean given
--EXPECT-CONVERTER-ERRORS--
30, 32, 32, 39, 45, 56, 62, 73, 75,
--ENDOFTEST--