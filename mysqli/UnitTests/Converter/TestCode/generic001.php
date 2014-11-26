--TEST--
SUCCESS: mysql_data_seek()
--FILE--
<?php
/*
mysql_data_seek

(PHP 3, PHP 4, PHP 5)
mysql_data_seek -- Move internal result pointer
Description
bool mysql_data_seek ( resource result, int row_number )

mysql_data_seek() moves the internal row pointer of the MySQL result associated with the specified result identifier to point to the specified row number. The next call to a MySQL fetch function, such as mysql_fetch_assoc(), would return that row.

row_number starts at 0. The row_number should be a value in the range from 0 to mysql_num_rows() - 1. However if the result set is empty (mysql_num_rows() == 0), a seek to 0 will fail with a E_WARNING and mysql_data_seek() will return FALSE.
Parameters

result

    The result resource that is being evaluated. This result comes from a call to mysql_query().
row_number

    The desired row number of the new result pointer. 

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

if (!mysqli_query( $con, "DELETE FROM nobody"))
    printf("FAILURE: cannot clear table nobody, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if (!mysqli_query( $con, "INSERT INTO nobody(id, msg) VALUES (1, 'one'), (2, 'two'), (3, 'three')"))
    printf("FAILURE: insert records into table nobody, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    
if (!($res = mysqli_query( $con, "SELECT id, msg FROM nobody ORDER BY id ASC"))) 
    printf("FAILURE: cannot fetch records, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$jumps = array(2 => 'three', 0 => 'one', 1 => 'two');
foreach ($jumps as $offset => $sql_value) {
    $ret = mysqli_data_seek($res,  $offset);
    
    if (!is_bool($ret))
        printf("FAILURE: seek() did not return boolean value, got %s value\n", gettype($ret));

    $row = mysqli_fetch_assoc($res);
    if ($row['msg'] != $sql_value)
        printf("FAILURE: expecting '%s', got '%s'\n", $sql_value, $row['msg']);  
}

$row = mysqli_fetch_assoc($res);
if ($row['msg'] != 'three')
    printf("FAILURE: expecting 'three', got '%s'\n", $row['msg']);  

$ret = mysqli_data_seek($res,  99);
if ($ret)
    printf("FAILURE: expecting false\n");
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);    
    
if (!($res = mysqli_query( $con, "SELECT id, msg FROM nobody WHERE 1 = 2"))) 
    printf("FAILURE: cannot fetch records, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  
$ret = mysqli_data_seek($res,  0);   
if ($ret)
    printf("FAILURE: expecting false and E_WARNING\n");

((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);        
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
--EXPECT-CONVERTER-ERRORS--
29, 31, 31, 36,
--ENDOFTEST--