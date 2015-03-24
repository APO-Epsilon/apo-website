<?php
session_start();

if (!isset($_GET['user_id'])) {
	die("Unable to determine user_id");
}

$exec_page = False;
$active_page = True;
$public_page = True;
require_once("../permissions.php");

function show_info($access) {
	require_once("../get_photo.php");
	$user_id = $_GET['user_id'];
	$photolink = getPhotoLink($user_id);
	include("../mysql_access.php");
	$sql = "SELECT firstname, lastname, pledgesem, pledgeyear FROM (SELECT id, firstname, lastname, pledgesem, pledgeyear FROM contact_information UNION DISTINCT SELECT id, firstname, lastname, pledgesem, pledgeyear FROM alumni UNION DISTINCT SELECT id, firstname, lastname, pledgesem, pledgeyear FROM alumni_info WHERE pledgesem<>\"\" AND pledgeyear<>\"\")all_users WHERE id=\"$user_id\";";
	$result = $db->query($sql);
	$row = mysqli_fetch_array($result);
	echo "<div class=\"row\"><div class=\"small-4 columns\">";
	echo "<img src=\"$photolink\">";
	echo "</div><div class=\"small-8 columns\">";
	echo "<h4>{$row['firstname']} {$row['lastname']}</h4>\n";
	echo "<p>Pledged: {$row['pledgesem']} {$row['pledgeyear']}</p></div>";
	echo "<div class=\"small-12 columns\"><h5>Bigs</h5>";
	$sql = "SELECT big_id, firstname, lastname FROM family_tree LEFT JOIN (SELECT id, firstname, lastname FROM contact_information UNION DISTINCT SELECT id, firstname, lastname FROM alumni UNION DISTINCT SELECT id, firstname, lastname FROM alumni_info WHERE pledgesem<>\"\" AND pledgeyear<>\"\")all_users ON family_tree.big_id=all_users.id WHERE little_id=\"$user_id\" ORDER BY lastname ASC;";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_array($result)) {
		echo "<div class=\"small-3 columns end text-center\"><div class=\"biglittle\" id=\"bl" . $row['big_id'] . "\">";
		echo "<img src=\"" . getPhotoLink($row['big_id']) . "\"><br>";
		echo "<p>" . $row['firstname'] . " " . $row['lastname'] . "</p>";
		echo "</div></div>";
	}
	echo "</div>";
	echo "<div class=\"small-12 columns\"><h5>Littles</h5>";
	$sql = "SELECT little_id, firstname, lastname FROM family_tree LEFT JOIN (SELECT id, firstname, lastname FROM contact_information UNION DISTINCT SELECT id, firstname, lastname FROM alumni UNION DISTINCT SELECT id, firstname, lastname FROM alumni_info WHERE pledgesem<>\"\" AND pledgeyear<>\"\")all_users ON family_tree.little_id=all_users.id WHERE big_id=\"$user_id\" ORDER BY lastname ASC;";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_array($result)) {
		echo "<div class=\"small-3 columns end text-center\"><div class=\"biglittle\" id=\"bl" . $row['little_id'] . "\">";
		echo "<img src=\"" . getPhotoLink($row['little_id']) . "\"><br>";
		echo "<p>" . $row['firstname'] . " " . $row['lastname'] . "</p>";
		echo "</div></div>";
	}
	echo "</div>";
}

function show_active() {
	show_info("active");
}

function show_public() {
	show_info("public");
}