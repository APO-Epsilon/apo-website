--TEST--
SUCCESS: mysql_field_flags()
--FILE--
<?php
/*
mysql_field_flags

(PHP 3, PHP 4, PHP 5)
mysql_field_flags -- Get the flags associated with the specified field in a result
Description
string mysql_field_flags ( resource result, int field_offset )

mysql_field_flags() returns the field flags of the specified field. The flags are reported as a single word per flag separated by a single space, so that you can split the returned value using explode().
Parameters

result

    The result resource that is being evaluated. This result comes from a call to mysql_query().
field_offset

    The numerical field offset. The field_offset starts at 0. If field_offset does not exist, an error of level E_WARNING is also issued.

Return Values

Returns a string of flags associated with the result, or FALSE on failure.

The following flags are reported, if your version of MySQL is current enough to support them: "not_null", "primary_key", "unique_key", "multiple_key", "blob", "unsigned", "zerofill", "binary", "enum", "auto_increment" and "timestamp". 

// string mysql_field_flags ( resource result, int field_offset )        
        // "not_null"           NOT_NULL_FLAG       MYSQLI_NOT_NULL_FLAG
        // "primary_key"        PRI_KEY_FLAG        MYSQLI_PRI_KEY_FLAG
        // "unique_key"         UNIQUE_KEY_FLAG     MYSQLI_UNIQUE_KEY_FLAG
        // "multiple_key"       MULTIPLE_KEY_FLAG   MYSQLI_MULTIPLE_KEY_FLAG
        // "blob"               BLOB_FLAG           MYSQLI_BLOB_FLAG
        // "unsigned"           UNSIGNED_FLAG       MYSQLI_UNSIGNED_FLAG
        // "zerofill"           ZEROFILL_FLAG       MYSQLI_ZEROFILL_FLAG
        // "binary"             BINARY_FLAG         !!!
        // "enum"               ENUM_FLAG           !!!
        // "auto_increment"     AUTO_INCREMENT_FLAG MYSQLI_AUTO_INCREMENT_FLAG
        // "timestamp"          TIMESTAMP_FLAG      MYSQLI_TIMESTAMP_FLAG
        // "set"                SET_FLAG            MYSQLI_SET_FLAG

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

$columns = array(
    'COL_NOT_NULL'      =>  array('INT NOT NULL', '1', 'not_null'),
    'COL_PRIMARY_KEY'   =>  array('INT PRIMARY KEY NOT NULL', '1', 'primary_key not_null'),    
    'COL_UNIQUE'        =>  array('INT UNIQUE', '1', 'unique_key'),
    'COL_BLOB'          =>  array('BLOB', '1', 'blob binary'),
    'COL_UNSIGNED'      =>  array('INT UNSIGNED', '1', 'unsigned'),
    'COL_ZEROFILL'      =>  array('INT ZEROFILL', '1', 'unsigned zerofill'),
    'COL_ENUM'          =>  array('ENUM("true", "false")', '"false"', 'enum'),
    'COL_AUTO_INC'      =>  array('INT AUTO_INCREMENT PRIMARY KEY NOT NULL', '1', 'primary_key not_null auto_increment'),
    'COL_TIMESTAMP'     =>  array('TIMESTAMP', '20060728235021', 'timestamp binary not_null unsigned zerofill'),    
    'COL_SET'           =>  array('SET("true", "false")', '"false"', 'set'),
    
);

foreach ($columns as $name => $column) {
    
    @mysqli_query( $con, 'DROP TABLE field_flags');
    
    $sql = sprintf('CREATE TABLE field_flags(%s %s)', $name, $column[0]);
    mysqli_query( $con, $sql);             
        
    $sql = sprintf('INSERT INTO field_flags(%s) values (%s)', $name, $column[1]);
    if (!mysqli_query( $con, $sql)) {
        printf("FAILURE: insert for column '%s' failed, [%d] %s\n",
            $column[0], ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        continue;            
    }
    
    if (!($res = mysqli_query( $con, 'SELECT * FROM field_flags'))) {
        printf("FAILURE: cannot select value of column %s failed, [%d] %s\n",
            $column[0], ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        continue;            
    }
    
    $fields = (($___mysqli_tmp = mysqli_fetch_field_direct($res,  0)->flags) ? (string)(substr((($___mysqli_tmp & MYSQLI_NOT_NULL_FLAG)       ? "not_null "       : "") . (($___mysqli_tmp & MYSQLI_PRI_KEY_FLAG)        ? "primary_key "    : "") . (($___mysqli_tmp & MYSQLI_UNIQUE_KEY_FLAG)     ? "unique_key "     : "") . (($___mysqli_tmp & MYSQLI_MULTIPLE_KEY_FLAG)   ? "unique_key "     : "") . (($___mysqli_tmp & MYSQLI_BLOB_FLAG)           ? "blob "           : "") . (($___mysqli_tmp & MYSQLI_UNSIGNED_FLAG)       ? "unsigned "       : "") . (($___mysqli_tmp & MYSQLI_ZEROFILL_FLAG)       ? "zerofill "       : "") . (($___mysqli_tmp & 128)                        ? "binary "         : "") . (($___mysqli_tmp & 256)                        ? "enum "           : "") . (($___mysqli_tmp & MYSQLI_AUTO_INCREMENT_FLAG) ? "auto_increment " : "") . (($___mysqli_tmp & MYSQLI_TIMESTAMP_FLAG)      ? "timestamp "      : "") . (($___mysqli_tmp & MYSQLI_SET_FLAG)            ? "set "            : ""), 0, -1)) : false);    
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
    
    if (!is_string($fields)) {
        printf("FAILURE: cannot fetch field flags of column '%s', got %s value instead of a string, [%d] %s\n",
            $column[0], gettype($fields), ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        continue;            
    }
        
    $fields     = explode(' ', $fields);
    $fields     = array_flip($fields);
    ksort($fields);
    $expected   = explode(' ', $column[2]);
    $expected   = array_flip($expected);
    ksort($expected);    
    $diff = array_diff($fields, $expected);    
    if (!empty($diff)) {    
        printf("FAILURE: the following fields are not expected: %s\n", implode(" ", $diff));
    }
    
}
  
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
--EXPECT-CONVERTER-ERRORS--
44, 46, 46, 51,
--ENDOFTEST--