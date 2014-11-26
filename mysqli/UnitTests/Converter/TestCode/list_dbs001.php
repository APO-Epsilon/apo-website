--TEST--
SUCCESS: mysql_list_dbs()
--FILE--
<?php
/*
mysql_list_dbs

(PHP 3, PHP 4, PHP 5)
mysql_list_dbs -- List databases available on a MySQL server
Description
resource mysql_list_dbs ( [resource link_identifier] )

Returns a result pointer containing the databases available from the current mysql daemon.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns a result pointer resource on success, or FALSE on failure. Use the mysql_tablename() function to traverse this result pointer, or any function for result tables, such as mysql_fetch_array(). 
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

if (!($res = (($___mysqli_tmp = mysqli_query($con, "SHOW DATABASES")) ? $___mysqli_tmp : false)))
    printf("FAILURE: mysql_list_dbs(con) failed, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

if (!($res = (($___mysqli_tmp = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW DATABASES")) ? $___mysqli_tmp : false)))
    printf("FAILURE: mysql_list_dbs() failed, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

$found = false;    
while ($row = mysqli_fetch_assoc($res)) {
    
    if (!array_key_exists('Database', $row))
        printf("FAILURE: hash does not have a 'Database' field, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    if ($row['Database'] == $db) {
        $found = true;
        break;
    }
}
if (!$found)
    printf("FAILURE: Database '%s' was not found\n", $db);

$res = (($___mysqli_tmp = mysqli_query($illegal_link_identifier, "SHOW DATABASES")) ? $___mysqli_tmp : false);
if (!is_bool($res))
    printf("FAILURE: expecting boolean value, got %s value, [%d] %s\n", gettype($res), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($res) 
    printf("FAILURE: expecting false, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
53, E_NOTICE, Undefined variable: illegal_link_identifier
53, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
60, E_WARNING, mysqli_free_result() expects parameter 1 to be mysqli_result, boolean given
--EXPECT-CONVERTER-ERRORS--
24, 26, 26,
--ENDOFTEST--