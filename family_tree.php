<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>

<div class="row">
	<div class="small-12 columns">

<?php
$exec_page = False;
$active_page = False;
$public_page = True;
require_once('permissions.php');

function show_public() {
	include('mysql_access.php');
	echo "<h2>APO Epsilon Family Tree</h2><br>";
	echo "<div id='family_tree' style='overflow: auto; height: 90%;'></div>";
	echo "<script type='text/vnd.graphviz' id='family_tree_script'>";
	echo <<<END
	digraph "family_tree" {
	graph [ bgcolor = transparent,
		label = "Really Long   asd f   asd f   asdf  ",
		fontsize = 35 ];
	node [	shape = polygon,
		sides = 4,
		distortion = "0.0",
		orientation = "0.0",
		skew = "0.0",
		color = blue,
		style = filled,
		fontname = "Helvetica-Outline" ];

END;
	$color = array("maroon", "red", "green", "chartreuse", "plum", "salmon", "goldenrod", "yellow", "blue", "cyan");
	$pledgecolor = array();
	$sql = "SELECT DISTINCT pledgeyear, pledgesem FROM contact_information ORDER BY pledgeyear DESC, pledgesem ASC;";
    $result = $db->query($sql);
    while ($row = mysqli_fetch_array($result)) {
    	$pledgecolor["{$row['pledgesem']} {$row['pledgeyear']}"] = array_pop($color);
    }
	$sql = "SELECT id, firstname, lastname, pledgeyear, pledgesem FROM contact_information;";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$pledgesemyear = $row['pledgesem'] . " " . $row['pledgeyear'];
		$nodecolor = $pledgecolor["$pledgesemyear"];
		echo "\"$id\" [label=\"$firstname $lastname\", id=\"$id\", color=$nodecolor];\n";
	}
	$sql = "SELECT big_id, little_id FROM family_tree;";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_array($result)) {
		$big = $row['big_id'];
		$little = $row['little_id'];
		echo "\"$big\" -> \"$little\";\n";
	}
	echo "} </script>";
	echo "<script src='/js/viz.js/viz.js'></script>";
	echo "<script>document.getElementById('family_tree').innerHTML = Viz(document.getElementById('family_tree_script').innerHTML, \"svg\", \"dot\")</script>";
}

?>
	</div>
</div>
    <div id="footer"></div>
</body>
</html>
