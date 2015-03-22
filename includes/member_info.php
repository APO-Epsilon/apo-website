<?php
require_once('../session.php');

if (!isset($_GET['user_id'])) {
	die("Unable to determine user_id");
}

$exec_page = False;
$active_page = True;
$public_page = True;
require_once("../permissions.php");

function show_info($access) {
	include("../mysql_access.php");
	$sql = "SELECT firstname, lastname, pledgesem, pledgeyear FROM contact_information WHERE id=\"{$_GET['user_id']}\";";
	$result = $db->query($sql);
	$row = mysqli_fetch_array($result);
	echo "<h4>{$row['firstname']} {$row['lastname']}</h4>\n";
	echo "<p>Pledged: {$row['pledgesem']} {$row['pledgeyear']}</p>";
}

function show_active() {
	show_info("active");
}

function show_public() {
	show_info("public");
}