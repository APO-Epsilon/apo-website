--TEST--
FAILURE: mysqli_fetch_object
--FILE--
<?php
/*
mysql_fetch_object

(PHP 3, PHP 4, PHP 5)
mysql_fetch_object -- Fetch a result row as an object
Description
object mysql_fetch_object ( resource result )

Returns an object with properties that correspond to the fetched row and moves the internal data pointer ahead.
Parameters

result

    The result resource that is being evaluated. This result comes from a call to mysql_query().

Return Values

Returns an object with properties that correspond to the fetched row, or FALSE if there are no more rows.

mysql_fetch_row() fetches one row of data from the result associated with the specified result identifier. The row is returned as an array. Each result column is stored in an array offset, starting at offset 0. 


NOTE: This function gets called too frequently, we did not take care of the different 
return types between ext/mysql (false) and ext/mysqli (NULL) in case of an error. It would
cost too much performance to convert the call to ((is_null($__f = func())) ? false : $__f).

NOTE: /* {{{ proto object mysql_fetch_object(resource result [, string class_name [, NULL|array ctor_params]]) 
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

$obj = mysqli_fetch_object($res);
if (!is_object($obj)) 
    printf("FAILURE: expecting object, got %s value, [%d] %s\n", gettype($obj), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($obj->msg != 'one')
    printf("FAILURE: expecting property 'msg' to have the value 'one', got '%s', [%d] %s\n", 
        $obj->msg,
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));    
        

if (!class_exists('foo')) {
    class foo {
        var $classname;
        function foo($classname) {
            $this->classname = $classname;
        }
    }
}
    
$obj = mysqli_fetch_object($res,  'foo');
if (get_class($obj) != 'foo')
    printf("FAILURE: expecting object of class 'foo', got object of class '%s', [%d] %s\n", 
        get_class($obj),
        ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));    

$obj = mysqli_fetch_object($res,  'foo',  array('bar'));        
if ($obj->classname != 'bar')
    printf("FAILURE: passing parameters to the custom class did not work,  [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

while ($obj = mysqli_fetch_object($res))
    ;

if (!is_bool($obj))
    printf("FAILURE: expecting boolean value because of empty result set, got %s value  [%d] %s\n", gettype($obj), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$obj = mysqli_fetch_object($illegal_result_identifier);
if (!is_bool($obj))
    printf("FAILURE: expecting boolean value because of invalid result identifier, got %s value  [%d] %s\n", gettype($obj), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
if ($obj)
    printf("FAILURE: expecting false, [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));    

    
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect
FAILURE: expecting boolean value because of empty result set, got NULL value  [0] 
FAILURE: expecting boolean value because of invalid result identifier, got NULL value  [0] 

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
66, E_WARNING, Missing argument 1 for foo::foo()
67, E_NOTICE, Undefined variable: classname
89, E_NOTICE, Undefined variable: illegal_result_identifier
89, E_WARNING, mysqli_fetch_object() expects parameter 1 to be mysqli_result, null given
--EXPECT-CONVERTER-ERRORS--
33, 35, 35, 40,
--ENDOFTEST--