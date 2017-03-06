<?php
require_once ('session.php');
require_once ('mysql_access.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->
<div class="row">

<?php
$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');

function show_active() {
	//check for proper parameters
	if(isset($_POST['submit']))
	{
		global $current_semester;
		$eid = $_POST['event_id'];
		$uid = $_POST['user'];
		$semester = $current_semester;
		
		if (!isset($_POST['Factor']))
		{
			$factor = 0;
			$drive = '';
			$day = '';
			$week = 0;
		}
		//regular service events have extra info
		else
		{
			$factor = $_POST['Factor'];
			$drive = $_POST['drive'];
			$day = $_POST['day'];
			$week = $_POST['week'];
		}
		include('mysql_access.php');
		//add their signup to the database
		$SQL = "INSERT INTO events_signup (event_id,user_id,semester,Factor,drive,day,week) VALUES ($eid,$uid,'$semester',$factor,'$drive','$day',$week)";
		$result = $db->query($SQL) or die("Signup Failed");

	}
	
	$uresponse=$db->query("SELECT firstname,lastname,email FROM contact_information WHERE id = $uid");
	$uresult=mysqli_fetch_array($uresponse);
	
	$eresponse=$db->query("SELECT event_leader_id FROM events_listing WHERE event_id = $eid");
	$eresult=mysqli_fetch_array($eresponse);
	$lid = $eresult['event_leader_id'];
	
	$lresponse=$db->query("SELECT email FROM contact_information WHERE id = $lid");
	$lresult=mysqli_fetch_array($lresponse);
	
	$user_name = $uresult['firstname'] . " " . $uresult['lastname'];
	$user_email = $uresult['email'];
	
	$event_name = $_POST['event_name'];
	echo '<h1> You are Signed Up for '. $event_name .'! </h1>';
	//change this link from test site to real site before uploading
	echo "<a href='event_signup.php'>SIGN UP FOR ANOTHER EVENT</a>";
	echo "<br><br><a href='check_requirements.php'>CHECK REQUIREMENTS HERE</a>";
	
	// the message
	$msg = "$user_name ($user_email) has signed up for your event $event_name.";

	// use wordwrap() if lines are longer than 70 characters
	//$msg = wordwrap($msg,70);

	// send email
	$subject = "APO SIGNUP : "  . $event_name;
	$to = $lresult['email'];
	mail($to,$subject,$msg);
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
