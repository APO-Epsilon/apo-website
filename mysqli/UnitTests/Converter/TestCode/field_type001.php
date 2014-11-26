--TEST--
SUCCESS: mysql_field_type()
--FILE--
<?php
/*
mysql_field_type

(PHP 3, PHP 4, PHP 5)
mysql_field_type -- Get the type of the specified field in a result
Description
string mysql_field_type ( resource result, int field_offset )

mysql_field_type() is similar to the mysql_field_name() function. The arguments are identical, but the field type is returned instead.
Parameters

result

    The result resource that is being evaluated. This result comes from a call to mysql_query().
field_offset

    The numerical field offset. The field_offset starts at 0. If field_offset does not exist, an error of level E_WARNING is also issued.

Return Values

The returned field type will be one of "int", "real", "string", "blob", and others as detailed in the MySQL documentation.         
NOTE: The test skips "geometry" and some other rather exotic data types.
NOTE: which values are reported depends on the version of the client library. The test is successfull 
if ext/mysql and ext/mysqli return the same values even if they look a bit strange (see below!). You might
have to adapt the test depending on the version of your client library.
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

        
$typelist = array( 
    'string'    =>  array(
                        'VARCHAR(1)'    => '"s"',
                        'VARBINARY(1)'  => '"s"',
                        'CHAR(1)'       => '"s"',
                        'BINARY(1)'     => '"s"',
                    ),
                    
    'int'       =>  array(
                        'TINYINT'       => 1,
                        'SMALLINT'      => 1,
                        'INTEGER'       => 1,
                        'BIGINT'        => 1,
                        'MEDIUMINT'     => 1,
                    ),
                        
    'real'      =>  array(
                        'FLOAT'         => 1,
                        'DOUBLE'        => 1,
                        'REAL'          => 1,
                        'DECIMAL(1,0)'  => 1,
                        
                    ),
    'timestamp' =>  array('TIMESTAMP'               => '"2006-07-31 17:18:43"'),
    'year'      =>  array('YEAR'                    => '"2006"'),
    'date'      =>  array('DATE'                    => '"2006-07-31"'),
    'time'      =>  array('TIME'                    => '"17:21:12"'),
    'set'       =>  array('SET("one", "two")'       => '"one"'),
    'enum'      =>  array('ENUM("true", "false")'   => '"true"'),
    'datetime'  =>  array('DATETIME'                => '"2006-08-01 10:12:38"'),
    'blob'      =>  array(
                        'BLOB'          => '"s"',
                        'TINYBLOB'      => '"s"',
                        'MEDIUMBLOB'    => '"s"',
                        'LONGBLOB'      => '"s"',
                        'TEXT'          => '"s"',
                        'TINYTEXT'      => '"s"',
                        'MEDIUMTEXT'    => '"s"',
                        'LONGTEXT'      => '"s"',                        
                    ), 
    'unknown'   =>  array('BIT(8)'                  => "b'1'"),
);

foreach ($typelist as $expected_type => $columns) {
    foreach ($columns as $sql_type => $sql_value) {
        
        @mysqli_query( $con, 'DROP TABLE field_types');
        
        if (!mysqli_query( $con, sprintf('CREATE TABLE field_types(col1 %s)', $sql_type))) {
            printf("FAILURE: skipping test for type %s/%s, cannot create table, [%d] %s\n", 
                $expected_type, $sql_type, 
                ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
            continue;
        }
        
        if (!mysqli_query( $con, sprintf('INSERT INTO field_types(col1) values (%s)', $sql_value))) {
            printf("FAILURE: skipping test for type %s/%s, cannot insert sql value '%s', [%d] %s\n", 
                $expected_type, $sql_type, $sql_value,
                ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
            continue;
        }
        
        if (!($res = mysqli_query( $con, "SELECT col1 FROM field_types"))) {
            printf("FAILURE: skipping test for type %s/%s, cannot fetch any records, [%d] %s\n", 
                $expected_type, $sql_type,
                ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
            continue;
        }       
        
        $type = ((is_object($___mysqli_tmp = mysqli_fetch_field_direct($res, 0)) && !is_null($___mysqli_tmp = $___mysqli_tmp->type)) ? ((($___mysqli_tmp = (string)(substr(( (($___mysqli_tmp == MYSQLI_TYPE_STRING) || ($___mysqli_tmp == MYSQLI_TYPE_VAR_STRING) ) ? "string " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_LONG, MYSQLI_TYPE_LONGLONG, MYSQLI_TYPE_INT24))) ? "int " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_FLOAT, MYSQLI_TYPE_DOUBLE, MYSQLI_TYPE_DECIMAL, ((defined("MYSQLI_TYPE_NEWDECIMAL")) ? constant("MYSQLI_TYPE_NEWDECIMAL") : -1)))) ? "real " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_TIMESTAMP) ? "timestamp " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_YEAR) ? "year " : "" ) . ( (($___mysqli_tmp == MYSQLI_TYPE_DATE) || ($___mysqli_tmp == MYSQLI_TYPE_NEWDATE) ) ? "date " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_TIME) ? "time " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_SET) ? "set " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_ENUM) ? "enum " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_GEOMETRY) ? "geometry " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_DATETIME) ? "datetime " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_TINY_BLOB, MYSQLI_TYPE_BLOB, MYSQLI_TYPE_MEDIUM_BLOB, MYSQLI_TYPE_LONG_BLOB))) ? "blob " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_NULL) ? "null " : "" ), 0, -1))) == "") ? "unknown" : $___mysqli_tmp) : false);        
        if (!is_string($type))
            printf("FAILURE: expecting string value, got %s value\n", gettype($type));

        if ($type != $expected_type) 
            printf("FAILURE: expected type %s for SQL type %s, reported type %s\n", $expected_type, $sql_type, $type);
            
           
        $type = ((is_object($___mysqli_tmp = mysqli_fetch_field_direct($res, 1)) && !is_null($___mysqli_tmp = $___mysqli_tmp->type)) ? ((($___mysqli_tmp = (string)(substr(( (($___mysqli_tmp == MYSQLI_TYPE_STRING) || ($___mysqli_tmp == MYSQLI_TYPE_VAR_STRING) ) ? "string " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_LONG, MYSQLI_TYPE_LONGLONG, MYSQLI_TYPE_INT24))) ? "int " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_FLOAT, MYSQLI_TYPE_DOUBLE, MYSQLI_TYPE_DECIMAL, ((defined("MYSQLI_TYPE_NEWDECIMAL")) ? constant("MYSQLI_TYPE_NEWDECIMAL") : -1)))) ? "real " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_TIMESTAMP) ? "timestamp " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_YEAR) ? "year " : "" ) . ( (($___mysqli_tmp == MYSQLI_TYPE_DATE) || ($___mysqli_tmp == MYSQLI_TYPE_NEWDATE) ) ? "date " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_TIME) ? "time " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_SET) ? "set " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_ENUM) ? "enum " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_GEOMETRY) ? "geometry " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_DATETIME) ? "datetime " : "" ) . ( (in_array($___mysqli_tmp, array(MYSQLI_TYPE_TINY_BLOB, MYSQLI_TYPE_BLOB, MYSQLI_TYPE_MEDIUM_BLOB, MYSQLI_TYPE_LONG_BLOB))) ? "blob " : "" ) . ( ($___mysqli_tmp == MYSQLI_TYPE_NULL) ? "null " : "" ), 0, -1))) == "") ? "unknown" : $___mysqli_tmp) : false);
        if (!is_bool($type))
            printf("FAILURE: expecting boolean value, got %s value\n", gettype($type));
        
        if ($type)
            printf("FAILURE: expecting false\n");
           
    }
}

        
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect
FAILURE: expected type real for SQL type DECIMAL(1,0), reported type unknown
FAILURE: expected type set for SQL type SET("one", "two"), reported type string
FAILURE: expected type enum for SQL type ENUM("true", "false"), reported type string

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect
FAILURE: expected type real for SQL type DECIMAL(1,0), reported type unknown
FAILURE: expected type set for SQL type SET("one", "two"), reported type string
FAILURE: expected type enum for SQL type ENUM("true", "false"), reported type string

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
120, E_WARNING, mysqli_fetch_field_direct(): Field offset is invalid for resultset
--EXPECT-CONVERTER-ERRORS--
31, 33, 33, 38,
--ENDOFTEST--