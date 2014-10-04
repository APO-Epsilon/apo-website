<?php
// MYSQLI vs MYSQL
// http://codular.com/php-mysqli
// http://www.pontikis.net/blog/how-to-use-php-improved-mysqli-extension-and-why-you-should
error_reporting(-1);
$DBServer = 'mysql.truman.edu';
$DBUser   = 'apo';
$DBPass   = 'glueallE17';
$DBName   = 'apo';

// Object oriented way (good way)
    $db = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// check connection
    if ($db->connect_error) {
      trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
    }
//more readable way of doing sql
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
}

/*

// procedural way (bad way)
$conn = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);
// check connection
if (mysqli_connect_errno()) {
  trigger_error('Database connection failed: '  . mysqli_connect_error(), E_USER_ERROR);
}

// really bad way of connect to mysql
    $db = mysql_connect("mysql.truman.edu", "apo", "glueallE17");
    if (!$db) {
            print "Error - Could not connect to mysql";
            exit;
    }

    $er = mysql_select_db("apo");
    if (!$er) {
            print "Error - Could not select database";
            exit;
    }

*/
?>