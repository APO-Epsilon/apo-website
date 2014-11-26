<?php
if(isset($_GET['id']) && isset($_GET['folder']))
{
// if id is set then get the file with the id from database

$db = ($GLOBALS["___mysqli_ston"] = mysqli_connect("mysql.truman.edu",  "apo",  "glueallE17"));
if (!$db) {
    print "Error - Could not connect to mysql";
    exit;
}

$er = ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE apo"));
if (!$er) {
	print "Error - Could not select database";
	exit;
}

$id    = $_GET['id'];
$folder = $_GET['folder'];
$query = "SELECT name, type, size, content " .
         "FROM upload WHERE id = '$id' AND folder = '$folder'";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
list($name, $type, $size, $content) = mysqli_fetch_array($result);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;

exit;
}

?>