--TEST--
SUCCESS: mysql_select_db
--FILE--
<?php
/*
mysql_select_db

(PHP 3, PHP 4, PHP 5)
mysql_select_db -- Select a MySQL database
Description
bool mysql_select_db ( string database_name [, resource link_identifier] )

Sets the current active database on the server that's associated with the specified link identifier. Every subsequent call to mysql_query() will be made on the active database.
Parameters

database_name

    The name of the database that is to be selected. 
link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns TRUE on success or FALSE on failure. 
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
        
if (!($res = mysqli_query( $con, "SELECT database() as db")))
    printf("FAILURE: cannot run SELECT, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if (!($row = mysqli_fetch_assoc($res)))
    printf("FAILURE: cannot fetch record, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($row["db"] != $db)
    printf("FAILURE: select_db() did not switch the DB, should be connected to DB %s, are connected to %s,  [%d] %s\n", $db, $row['db'], ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);    

if (!((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE $db")))
    printf("FAILURE: cannot select db (default connection) '%s', [%d] %s\n",
        $db, ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        
if (!($res = mysqli_query( $con, "SELECT database() as db")))
    printf("FAILURE: cannot run SELECT (default connection), [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if (!($row = mysqli_fetch_assoc($res)))
    printf("FAILURE: cannot fetch record (default connection), [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($row["db"] != $db)
    printf("FAILURE: select_db() did not switch the DB (default connection), should be connected to DB %s, are connected to %s,  [%d] %s\n", $db, $row['db'], ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

if (!defined('SELECT_DB_DATABASE'))
    define('SELECT_DB_DATABASE', $db);
    
if (!((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('SELECT_DB_DATABASE'))))
    printf("FAILURE [SELECT_DB_DATABASE]: cannot select db (default connection) '%s', [%d] %s\n",
        SELECT_DB_DATABASE, ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        
if (!($res = mysqli_query( $con, "SELECT database() as db")))
    printf("FAILURE [SELECT_DB_DATABASE]: cannot run SELECT (default connection), [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if (!($row = mysqli_fetch_assoc($res)))
    printf("FAILURE [SELECT_DB_DATABASE]: cannot fetch record (default connection), [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($row["db"] != SELECT_DB_DATABASE)
    printf("FAILURE [SELECT_DB_DATABASE]: select_db() did not switch the DB (default connection), should be connected to DB %s, are connected to %s,  [%d] %s\n", SELECT_DB_DATABASE, $row['db'], ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);


$res = ((bool)mysqli_query( $illegal_link_identifier, "USE $db"));
if (!is_bool($res))
    printf("FAILURE: expecting boolean value, got %s value\n", gettype($res));
    
if ($res)
    printf("FAILURE: expecting false because of illegal link\n");

$res = ((bool)mysqli_query( $con, "USE this_database_does_never_ever_exist_27278kajha"));
if ($res)
    printf("FAILURE: expecting false because of unknown database\n");

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
83, E_NOTICE, Undefined variable: illegal_link_identifier
83, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
27, 29, 29, 34, 49, 51, 51, 54, 54, 57, 57, 60, 60, 67, 69, 69, 72, 72, 75, 75, 78, 78, 83, 90,
--ENDOFTEST--