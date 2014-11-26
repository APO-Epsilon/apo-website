--TEST--
SUCCESS: mysql_drop_db()
--FILE--
<?php
/*
mysql_drop_db

(PHP 3, PHP 4, PHP 5)
mysql_drop_db -- Drop (delete) a MySQL database
Description
bool mysql_drop_db ( string database_name [, resource link_identifier] )

mysql_drop_db() attempts to drop (remove) an entire database from the server associated with the specified link identifier. This function is deprecated, it is preferable to use mysql_query() to issue a sql DROP DATABASE statement instead.
Parameters

database_name

    The name of the database that will be deleted. 
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

if (function_exists('mysqli_query')) {   

    $test_db_name = "__converter_test_create_db";
    
    $ret = ((is_null($___mysqli_res = mysqli_query( $con, "CREATE DATABASE $test_db_name"))) ? false : $___mysqli_res);    
    if (!$ret)
        printf("FAILURE: failed to create test database [1], check your setup! FAILURE: [%d] %s\n", 
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $ret = ((is_null($___mysqli_res = mysqli_query( $con, "DROP DATABASE $test_db_name"))) ? false : $___mysqli_res);
    if (!is_bool($ret))
        printf("FAILURE: mysql_drop_db(name, con) did not return boolean value, got %s, [%d] %s\n", 
            gettype($ret), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    if (!$ret)
        printf("FAILURE: mysql_drop_db(name, con) failed, [%d] %s\n",
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $ret = ((is_null($___mysqli_res = mysqli_query($GLOBALS["___mysqli_ston"], "CREATE DATABASE $test_db_name"))) ? false : $___mysqli_res);    
    if (!$ret)
        printf("FAILURE: failed to create test database [2], check your setup! FAILURE: [%d] %s\n", 
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $ret = ((is_null($___mysqli_res = mysqli_query($GLOBALS["___mysqli_ston"], "DROP DATABASE $test_db_name"))) ? false : $___mysqli_res);
    if (!is_bool($ret))
        printf("FAILURE: mysql_drop_db(name) did not return boolean value, got %s, [%d] %s\n", 
            gettype($ret), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    if (!$ret)
        printf("FAILURE: mysql_drop_db(name) failed, [%d] %s\n",
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));            
            
    $ret = ((is_null($___mysqli_res = mysqli_query( $illegal_link_identifier, "DROP DATABASE $test_db_name"))) ? false : $___mysqli_res);
    if (!is_bool($ret))
        printf("FAILURE: mysql_drop_db(name, illegal link identifier) did not return boolean value, got %s, [%d] %s\n", 
            gettype($ret), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    if ($ret)
        printf("FAILURE: mysql_drop_db(name, illegal link identifier) failed, [%d] %s\n",
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));                                
}

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
66, E_NOTICE, Undefined variable: illegal_link_identifier
66, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
27, 29, 29, 38, 43, 52, 57, 66,
--ENDOFTEST--