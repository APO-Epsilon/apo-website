--TEST--
SUCCESS: mysql_create_db()
--FILE--
<?php
/*
mysql_create_db

(PHP 3, PHP 4, PHP 5)
mysql_create_db -- Create a MySQL database
Description
bool mysql_create_db ( string database_name [, resource link_identifier] )

mysql_create_db() attempts to create a new database on the server associated with the specified link identifier.
Parameters

database_name

    The name of the database being created. 
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
    if (!is_bool($ret))
        printf("FAILURE: boolean return value expected, got %s\n", gettype($ret));

    if (!$ret)
        printf("FAILURE: failed to create test database, check your setup! FAILURE: [%d] %s\n", 
            ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    if (!mysqli_query( $con, "DROP DATABASE " . $test_db_name))
        printf("FAILURE: cannot drop test database '%s', check your setup! FAILURE: [%d] %s\n", 
            $test_db_name, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $ret = ((is_null($___mysqli_res = mysqli_query($GLOBALS["___mysqli_ston"], "CREATE DATABASE $test_db_name"))) ? false : $___mysqli_res);
    if (!$ret)
        printf("FAILURE: failed to create test database '%s' using the default connection, check your setup! FAILURE: [%d] %s\n", 
            $test_db_name, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (!mysqli_query($GLOBALS["___mysqli_ston"], "DROP DATABASE " . $test_db_name))
        printf("FAILURE: cannot drop test database '%s' using the default connection, check your setup! FAILURE: [%d] %s\n", 
            $test_db_name, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (!defined('CREATE_DB_DATABASE'))
        define('CREATE_DB_DATABASE', $test_db_name);
                    
    $ret = ((is_null($___mysqli_res = mysqli_query($GLOBALS["___mysqli_ston"], "CREATE DATABASE " . constant('CREATE_DB_DATABASE')))) ? false : $___mysqli_res);
    if (!$ret)
        printf("FAILURE [CREATE_DB_DATABASE]: failed to create test database '%s' using the default connection, check your setup! FAILURE: [%d] %s\n", 
            CREATE_DB_DATABASE, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (!mysqli_query($GLOBALS["___mysqli_ston"], "DROP DATABASE " . CREATE_DB_DATABASE))
        printf("FAILURE [CREATE_DB_DATABASE]: cannot drop test database '%s' using the default connection, check your setup! FAILURE: [%d] %s\n", 
            CREATE_DB_DATABASE, ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));            
    

    $ret = ((is_null($___mysqli_res = mysqli_query( $illegal_link_identifier, "CREATE DATABASE $test_db_name"))) ? false : $___mysqli_res);
    if (!is_bool($ret))
        printf("FAILURE: boolean return value expected because of illegal link identifier, got %s\n", gettype($ret));    
}

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
71, E_NOTICE, Undefined variable: illegal_link_identifier
71, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
27, 29, 29, 37, 49, 61, 71,
--ENDOFTEST--