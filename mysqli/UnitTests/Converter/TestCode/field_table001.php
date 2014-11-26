--TEST--
SUCCESS: mysql_field_table()
--FILE--
<?php
/*
mysql_field_table

(PHP 3, PHP 4, PHP 5)
mysql_field_table -- Get name of the table the specified field is in
Description
string mysql_field_table ( resource result, int field_offset )

Returns the name of the table that the specified field is in.
Parameters

result

    The result resource that is being evaluated. This result comes from a call to mysql_query().
field_offset

    The numerical field offset. The field_offset starts at 0. If field_offset does not exist, an error of level E_WARNING is also issued.

Return Values

The name of the table on success. 
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

mysqli_query( $con, "DELETE FROM nobody");

if (!mysqli_query( $con, "INSERT INTO nobody(id, msg) VALUES (1, 'msg')"))
    printf("FAILURE: cannot insert a dummy row, [%d] %s\n",
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if (!($res = mysqli_query( $con, "SELECT * FROM nobody")))
    printf("FAILURE: cannot fetch the dummy row, [%d] %s\n",
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


$table_name = (mysqli_fetch_field_direct($res,  1)->table);
if (!is_string($table_name))
    printf("FAILURE: expecting integer value, got %s value\n", gettype($table_name));
    
if ($table_name != 'nobody')
    printf("FAILURE: expecting 'msg', got '%s'\n", $table_name);
    
$table_name = ((($___mysqli_tmp = mysqli_fetch_field_direct($res, 2)->name) && (!is_null($___mysqli_tmp))) ? $___mysqli_tmp : false);
if (!is_bool($table_name))
    printf("FAILURE: expecting boolean value, got %s value\n", gettype($table_name));
    
if ($table_name)
    printf("FAILURE: expecting false, got true\n");
        
    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
56, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
56, E_NOTICE, Trying to get property of non-object
--EXPECT-CONVERTER-ERRORS--
27, 29, 29, 34,
--ENDOFTEST--