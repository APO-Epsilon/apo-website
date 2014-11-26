<?php
require_once ('layout.php');
require_once ('mysql_access.php');
//require_once ('service_admin_forms.php');
//require_once ('service_admin_functions.php');
page_header();
$id = $_SESSION['sessionID'];
$position = $_SESSION['sessionposition'];
?> <div class="content">
<?php
if($position != "Webmaster" && $position != "VP of Regular Service"){
	die("you do not have sufficient permissions to view this page.");
}
echo "<h2>Disabled</h2>";/*
echo "<h1>Service Manager: VP of Regular Service</h1><hr/>";
echo "<h4><a href=\"http://apo.truman.edu/service_admin_week.php\">back to dashboard</a></h4>";

//if a form has been submitted, do the associated action
if(isset($_POST['submit'])){
	if(isset($_POST['newEventFormSubmit'])){
		newEvent();
	}elseif(isset($_POST['assignPLFormSubmit'])){
		assignPL();
	}elseif(isset($_POST['eventDetailsFormSubmit'])){
		eventDetails();
	}elseif(isset($_POST['removeEventFormSubmit'])){
		$event = $_POST['event'];
		removeEvent($event);
	}elseif(isset($_POST['editEventFormSubmit'])){
		$event = $_POST['event'];
		modifyEvent($event);
	}elseif(isset($_POST['editEventFormSubmit2'])){
		$event = $_POST['event'];
		modifyEvent2($event);
	}
	
}elseif(isset($_GET['remove'])){
	removePL($_GET['d'],$_GET['u']);
}elseif(isset($_POST['Navigate'])){
	$start = $_POST['start'];
	$end = $_POST['end'];
	$max = $_POST['max'];
	$length = $_POST['length'];
	$detail_id = $_POST['detail_id'];
	submitModifyEvent($start,$end,$max,$length,$detail_id);
}elseif(isset($_POST['Navigate2'])){
	$description = $_POST['description'];
	$location = $_POST['location'];
	$notes = $_POST['notes'];
	$P_Id = $_POST['P_Id'];
	submitModifyEvent2($description, $location, $notes, $P_Id);
}else{
		newEventForm();
		editEventForm2();
		eventDetailsForm();
		removeEventForm();
		editEventForm();
		assignPLForm();
		/** Display **
		displayProjectList();
	
}*/
?> </div>
<?php 
page_footer();
?>