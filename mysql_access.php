<?php
// MYSQLI vs MYSQL
// http://codular.com/php-mysqli
// http://www.pontikis.net/blog/how-to-use-php-improved-mysqli-extension-and-why-you-should
error_reporting(-1);
global $DBServer = 'apo.cxav86kuligx.us-west-2.rds.amazonaws.com';
global $DBUser   = 'apo';
global $DBPass   = 'alphaphiomega';
global $DBName   = 'apo';

// Object oriented way (good way)


/*class rds_mysqli extends mysqli {
    public function __construct($DBServer, $DBUser, $DBPass, $DBName) {
        parent::__construct($DBServer, $DBUser, $DBPass, $DBName);

        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
    }
}*/
global $db = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// check connection
if ($db->connect_error) {
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}

//example way of doing a more readable sql query
/*
$sql = <<<SQL
    SELECT *
    FROM `apo`.`contact_information`
    WHERE id = 419
SQL;

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}
while($row = $result->fetch_assoc()){
    echo $row['firstname'] . '<br />';
}*/
/* old mysql way of connecting
define('DB_HOST', 'apo.cxav86kuligx.us-west-2.rds.amazonaws.com');
define('DB_NAME', 'apo');
define('DB_USER','apo');
define('DB_PASSWORD','alphaphiomega');

$db=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$er=mysql_select_db(DB_NAME,$db) or die("Failed to connect to MySQL: " . mysql_error());
*/
?>