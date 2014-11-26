<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();
echo("<div class=\"content\">");
$userID = $_SESSION['sessionID'];

$sql = "SELECT ns.index, ns.who, ns.seen, n.index, n.message AS message, n.timestamp AS timestamp, n.who
		FROM news AS n
		JOIN news_seen AS ns
		ON ns.index = n.index
		WHERE ns.seen = '0'
		AND ns.who = ".$userID."
		ORDER BY n.timestamp DESC
		LIMIT 1";
$result = mysql_query($sql);
if(mysql_num_rows($result) != 0){
	while($r = mysql_fetch_array($result)){
		$message = $r['message'];
		$timestamp = $r['timestamp'];
	}
	echo $timestamp."<p>".$message;
}

$sql = "UPDATE news_seen AS ns SET ns.seen = 1 WHERE ns.who = ".$userID."";
$result = mysql_query($sql);
if($result){
	echo "";
}else{
	echo("something went wrong");
}
echo "</div>";
page_footer();
?>