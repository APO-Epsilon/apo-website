<?php
require_once('Generic.php');

/**
* Converter: mysql_field_table
*
* @category   Functions
* @package    MySQLConverterTool
* @author     Andrey Hristov <andrey@php.net>, Ulf Wendel <ulf.wendel@phpdoc.de>
* @copyright  1997-2006 The PHP Group
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0
* @version    CVS: $Id:$, Release: @package_version@
* @link       http://www.mysql.com
* @since      Class available since Release 1.0
*/
class MySQLConverterTool_Function_FieldTable extends MySQLConverterTool_Function_Generic {
  
    
    public $new_name = 'mysqli_fetch_field_direct';

    
    public function __construct() 
    {   
    }
  
    
    function handle(Array $params = array()) 
    {
        // string mysql_field_table ( resource result, int field_offset )
        // object mysqli_fetch_field_direct ( mysqli_result result, int fieldnr )
        
        if (count($params) != 2)
            return array(self::PARSE_ERROR_WRONG_PARAMS, NULL);

        list($res, $i) = $this->extractParamValues($params);

        return array(NULL, "(mysqli_fetch_field_direct($res, $i)->table)");        
    }
    
    
    function getConversionHint() {
        
        return 'Emulated using mysqli_fetch_field_direct().';
    }

}
?>