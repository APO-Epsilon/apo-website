<?php
require_once ('layout.php');
require_once ('mysql_access.php');

function process_new(){
	$note = $_POST['note'];
	$who = $_POST['who'];

$sql = "INSERT INTO news
		(message, who)
		VALUES ('".$note."','".$who."')";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);


$sql = "SELECT `index`
		FROM  `news` 
		ORDER BY  `news`.`index` DESC
		LIMIT 1";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
while($r = mysqli_fetch_array($result)){
	$index = $r['index'];
}

$sql2 = "SELECT id, lastname FROM contact_information
		WHERE status = '".$who."'";
$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2);
while($v = mysqli_fetch_array($result2)){
	//echo $v['id']." : ".$v['lastname']."<br/>";
	$sql1 = "INSERT INTO news_seen
			(`index`, `who`)
			VALUES (".$index.",".$v['id'].")";
	$result1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql1);
	if(!$result1){
		echo "<br/>".$index.":".$v['id'].":".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
		// echo("something went wrong");
	}
}


}

$position = $_SESSION['sessionposition'];
if($position != 'Webmaster'){
	echo "you do not have permission to view this page.";
}else{

if(isset($_POST['note'])){
	process_new();
}else{
	echo "<table><tr><td>";
	$sql = "SELECT DISTINCT(status) AS p_distinct
			FROM contact_information 
			WHERE status IS NOT NULL 
			AND status != ''";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	while($r = mysqli_fetch_array($result)){
		$d = $r['p_distinct'];
		$distinct_positions[] .= $d;
	}
echo "</td><td>
<form method=\"post\" action=\"$_SERVER[PHP_SELF]\" id=\"nav\">";
		for($i=0;$i<count($distinct_positions);$i++){
			echo("<input type=\"checkbox\" name=\"who[]\" value=\"".
				$distinct_positions[$i]."\">".$distinct_positions[$i]."<br/>");
		}
echo "
<textarea rows=\"10\" cols=\"50\" name=\"note\">
		</textarea>
<input type=\"submit\" value=\"submit\"/></form></td></tr></table>";
}
}
?>