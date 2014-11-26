--TEST--
SUCCESS: mysql_tablename
--FILE--
<?php
/*
mysql_tablename

(PHP 3, PHP 4, PHP 5)
mysql_tablename -- Get table name of field
Description
string mysql_tablename ( resource result, int i )

Retrieves the table name from a result.

This function deprecated. It is preferable to use mysql_query() to issue a SQL SHOW TABLES [FROM db_name] [LIKE 'pattern'] statement instead.
Parameters

result

    A result pointer resource that's returned from mysql_list_tables(). 
i

    The integer index (row/table number) 

Return Values

The name of the table on success, or FALSE on failure.

Use the mysql_tablename() function to traverse this result pointer, or any function for result tables, such as mysql_fetch_array(). 
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES FROM $db");
$num = mysqli_num_rows($res);

$found = false;
for ($i = 0; $i <= $num; $i++) {

    $table = ((mysqli_data_seek($res,  $i) && (($___mysqli_tmp = mysqli_fetch_row($res)) !== NULL)) ? array_shift($___mysqli_tmp) : false);
    if (!is_string($table))
        printf("FAILURE: expecting string value, got %s value, [%d] %s\n", 
            gettype($table), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    if ($table == 'nobody') {
        $found = true;
        break;
    }
}

if (!$found)
    printf("FAILURE: could not find table 'nobody'\n");
    
$table = ((mysqli_data_seek($res,  999) && (($___mysqli_tmp = mysqli_fetch_row($res)) !== NULL)) ? array_shift($___mysqli_tmp) : false);
if (!is_bool($table))    
    printf("FAILURE: expecting boolean value (invalid offset), got %s value, [%d] %s\n", 
        gettype($table), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        
if ($table)
    printf("FAILURE: expecting false (invalid offset)\n");
    
$table = ((mysqli_data_seek($illegal_result_identifier,  1) && (($___mysqli_tmp = mysqli_fetch_row($illegal_result_identifier)) !== NULL)) ? array_shift($___mysqli_tmp) : false);    
if (!is_bool($table))    
    printf("FAILURE: expecting boolean value (illegal result identifier), got %s value, [%d] %s\n", 
        gettype($table), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if ($table)
    printf("FAILURE: expecting false (illegal result identifier)\n");
        

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
66, E_NOTICE, Undefined variable: illegal_result_identifier
66, E_WARNING, mysqli_data_seek() expects parameter 1 to be mysqli_result, null given
--EXPECT-CONVERTER-ERRORS--
31, 33, 33, 38,
--ENDOFTEST--