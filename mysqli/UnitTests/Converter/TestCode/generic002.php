--TEST--
FAILURE: mysqli_fetch_array()
--FILE--
<?php
/*
mysql_fetch_array

(PHP 3, PHP 4, PHP 5)
mysql_fetch_array -- Fetch a result row as an associative array, a numeric array, or both
Description
array mysql_fetch_array ( resource result [, int result_type] )

Returns an array that corresponds to the fetched row and moves the internal data pointer ahead.
Parameters

result

    The result resource that is being evaluated. This result comes from a call to mysql_query().
result_type

    The type of array that is to be fetched. It's a constant and can take the following values: MYSQL_ASSOC, MYSQL_NUM, and the default value of MYSQL_BOTH. 

Return Values

Returns an array that corresponds to the fetched row, or FALSE if there are no more rows. The type of returned array depends on how result_type is defined. By using MYSQL_BOTH (default), you'll get an array with both associative and number indices. Using MYSQL_ASSOC, you only get associative indices (as mysql_fetch_assoc() works), using MYSQL_NUM, you only get number indices (as mysql_fetch_row() works).

If two or more columns of the result have the same field names, the last column will take precedence. To access the other column(s) of the same name, you must use the numeric index of the column or make an alias for the column. For aliased columns, you cannot access the contents with the original column name. 

NOTE: This function gets called too frequently, we did not take care of the different 
return types between ext/mysql (false) and ext/mysqli (NULL) in case of an error. It would
cost too much performance to convert the call to ((is_null($__f = func())) ? false : $__f).
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

if (!mysqli_query( $con, "DELETE FROM nobody"))
    printf("FAILURE: cannot clear table nobody, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if (!mysqli_query( $con, "INSERT INTO nobody(id, msg) VALUES (1, 'one'), (2, 'two'), (3, 'three'), (4, 'four')"))
    printf("FAILURE: insert records into table nobody, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    
if (!($res = mysqli_query( $con, "SELECT id, msg FROM nobody ORDER BY id ASC"))) 
    printf("FAILURE: cannot fetch records, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    
$ret = mysqli_fetch_array($res);
if (!is_array($ret))
    printf("FAILURE: expecting array value, got %s value, [%d] %s\n", 
        gettype($ret), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));  
        
        
$ret = mysqli_fetch_array($res,  MYSQLI_NUM);
if (!is_array($ret))
    printf("FAILURE: expecting array value, got %s value, [%d] %s\n", 
        gettype($ret), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));  

if (array_key_exists("id", $ret))
    printf("FAILURE: got hash, asked for array by specifying MYSQL_NUM, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              

if (!array_key_exists(0, $ret))
    printf("FAILURE: did not get an array, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              
    
if ($ret[0] != 2)
    printf("FAILURE: expecting 2, '%s' returned [%d] %s\n", $ret[0], ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    
$ret = mysqli_fetch_array($res,  MYSQLI_ASSOC);
if (array_key_exists(0, $ret))
    printf("FAILURE: got array, asked for hash by specifying MYSQL_ASSOC, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              
    
if (!array_key_exists('id', $ret))
    printf("FAILURE: did not get a hash, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($ret['id'] != 3)
    printf("FAILURE: expecting 3, '%s' returned [%d] %s\n", $ret[0], ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
       

$ret = mysqli_fetch_array($res,  MYSQLI_BOTH);
if (!array_key_exists('id', $ret))
    printf("FAILURE: asked for MYSQL_BOTH, but seems not to contain the MYSQL_ASSOC values, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              
    
if (!array_key_exists(0, $ret))
    printf("FAILURE: asked for MYSQL_BOTH, but seems not to contain the MYSQL_ARRAY values, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              

if ($ret['id'] != $ret[0])
    printf("FAILURE: asked for MYSQL_BOTH, but got something strange, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              

while ($ret = mysqli_fetch_array($res))
    ;

if (!is_bool($ret))
    printf("FAILURE: expecting false because of no more records, got %s value, [%d] %s\n", 
        gettype($ret),
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              
    
$ret = mysqli_fetch_array($invalid_link_identifier);
if (!is_bool($ret))
    printf("FAILURE: expecting false because of invalid link identifier, got %s value, [%d] %s\n", 
        gettype($ret),
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));              
        
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect
FAILURE: expecting false because of no more records, got NULL value, [0] 
FAILURE: expecting false because of invalid link identifier, got NULL value, [0] 

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
105, E_NOTICE, Undefined variable: invalid_link_identifier
105, E_WARNING, mysqli_fetch_array() expects parameter 1 to be mysqli_result, null given
--EXPECT-CONVERTER-ERRORS--
33, 35, 35, 40,
--ENDOFTEST--