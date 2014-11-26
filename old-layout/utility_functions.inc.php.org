<?
function newPDO(){

	$dsn = "mysql:host=mysql.truman.edu;dbname=apo";
	$user = "apo";
	$pass = "glueallE17";

	return new PDO($dsn, $user, $pass);
}
?>