<?php
function newPDO(){
	return new PDO('mysql:host=mysql.truman.edu;dbname=apo', 'apo', 'glueallE17');
}
/*
sample usage
$pdo = new PDO('mysql:host=$host;dbname=$db', 'apo', 'glueallE17');
$statement = $pdo->query("SELECT firstname AS _firstname FROM contact_information");
$row = $statement->fetch(PDO::FETCH_ASSOC);
echo htmlentities($row['_firstname']);
*/

$pdo = newPDO();
$statement = $pdo->query("SELECT firstname AS _firstname FROM contact_information");
$row = $statement->fetch(PDO::FETCH_ASSOC);
echo htmlentities($row['_firstname']);

if ($db->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') {
    $stmt = $db->prepare('select * from contact_information',
        array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
} else {
    die("my application only works with mysql; I should use \$stmt->fetchAll() instead");
}
?>