--TEST--
FAILURE: mysql_list_fields()
--FILE--
<?php
/*
mysql_list_fields

(PHP 3, PHP 4, PHP 5)
mysql_list_fields -- List MySQL table fields
Description
resource mysql_list_fields ( string database_name, string table_name [, resource link_identifier] )

Retrieves information about the given table name.

This function is deprecated. It is preferable to use mysql_query() to issue a SQL SHOW COLUMNS FROM table [LIKE 'name'] statement instead.
Parameters

database_name

    The name of the database that's being queried. 
table_name

    The name of the table that's being queried. 
link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

A result pointer resource on success, or FALSE on failure.

The returned result can be used with mysql_field_flags(), mysql_field_len(), mysql_field_name() and mysql_field_type(). 
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
   
if (!($res = (($___mysqli_tmp = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW COLUMNS FROM $db.nobody")) ? $___mysqli_tmp : false)))
    printf("FAILURE: cannot run mysql_list_fields() on default connection, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

$row = mysqli_fetch_array($res);

if (!is_array($row))
    printf("FAILURE: expecting array, got %s value, [%d] %s\n", gettype($row), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if (!array_key_exists(0, $row) || !array_key_exists("Field", $row) || $row[0] != $row["Field"])
    printf("FAILURE: hash looks strange, [%d] %s\n", gettype($row), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));    
    
if ($row["Field"] != "id")
    printf("FAILURE: strange field name,  [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);    
    
if (!($res = (($___mysqli_tmp = mysqli_query( $con, "SHOW COLUMNS FROM $db.nobody")) ? $___mysqli_tmp : false)))
    printf("FAILURE: cannot run mysql_list_fields(), [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

$res = (($___mysqli_tmp = mysqli_query( $illegal_link_identifier, "SHOW COLUMNS FROM $db.nobody")) ? $___mysqli_tmp : false);

if (!is_bool($res))
    printf("FAILURE: expecting boolean value (illegal link identifier), got %s value,  [%d] %s\n", gettype($row), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));  
    
if ($res)
    printf("FAILURE: expecting false (illegal link identifier), got true,   [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));  

if (!defined('LIST_FIELDS_TABLE'))    
    define('LIST_FIELDS_TABLE', 'nobody');    
    
if (!($res = (($___mysqli_tmp = mysqli_query( $con, "SHOW COLUMNS FROM $db." . constant('LIST_FIELDS_TABLE'))) ? $___mysqli_tmp : false)))
    printf("FAILURE [LIST_FIELDS_TABLE]: cannot run mysql_list_fields(), [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$row = mysqli_fetch_array($res);
if ($row['Field'] != 'id')
    printf("FAILURE [LIST_FIELDS_TABLE]: return value looks strange, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));   

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
    
if (!defined('LIST_FIELDS_DATABASE'))    
    define('LIST_FIELDS_DATABASE', $db);    
    
if (!($res = (($___mysqli_tmp = mysqli_query( $con, "SHOW COLUMNS FROM " . constant('LIST_FIELDS_DATABASE') . "." . constant('LIST_FIELDS_TABLE'))) ? $___mysqli_tmp : false)))
    printf("FAILURE [LIST_FIELDS_DATABASE, LIST_FIELDS_TABLE]: cannot run mysql_list_fields(), [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$row = mysqli_fetch_array($res);
if ($row['Field'] != 'id')
    printf("FAILURE [LIST_FIELDS_DATABASE, LIST_FIELDS_TABLE]: return value looks strange, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));   

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect
FAILURE: expecting array, got boolean value, [0] 
FAILURE: hash looks strange, [0] 0
FAILURE: strange field name,  [0] 
FAILURE [LIST_FIELDS_TABLE]: return value looks strange, [0] 
FAILURE [LIST_FIELDS_DATABASE, LIST_FIELDS_TABLE]: return value looks strange, [0] 

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
66, E_NOTICE, Undefined variable: illegal_link_identifier
66, E_WARNING, mysqli_query() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
34, 36, 36, 41, 45, 61, 66, 77, 89,
--ENDOFTEST--