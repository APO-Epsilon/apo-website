<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28249243-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php
session_start();

// Yeah, these are kind of important.  A lot of random pages use them.
// So don't mess with them.  Make sure as you update the semesters you keep them
// the same,  that is don't switch previous_semester to "Fall10" if it was "Fall 2010"
$previous_semester = "Spring 2014";
$current_semester = "Fall 2014";
$next_semester = "Spring 2015";

function page_header() {


	// Evil code to force memembers to update their information each new semester.
	// Seriously, evil.  You cannot do anything until you update.
	// -- Stephen Quinn
	global $current_semester;
	if (isset($_SESSION['active_sem'])) {
		if ($_SESSION['active_sem'] != $current_semester) {
			if (($_SERVER["REQUEST_URI"] != "./members_updateinfo.php?forced=true") AND ($_SERVER["REQUEST_URI"] != "./members_updateinfo.php")) {

					header( 'Location: ./members_updateinfo.php?forced=true' ) ;

			}
		}
	}
/*
	//updates the service_occurrence table to auto-deactivate events in the past
	$sql = "UPDATE service_occurrence SET active = 0 WHERE theDate < DATE(NOW())";
	$result = mysql_query($sql);

	$datew = date('w');
	$dateG = date('G');
	if($datew == 6 && $dateG >= 13){//Friday
		$sql = "UPDATE service_occurrence SET active = 1 WHERE active = 3";
		$sql2 = "UPDATE service_occurrence SET active = 2 WHERE active = 4";
		$result = mysql_query($sql);
		$result = mysql_query($sql2);
	}

	$sql = "SELECT COUNT(*) AS count FROM service_attendance WHERE processed = 1";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
		$count = $r['count'];
	}
	if($count > 0){
		require_once('service_hours_logger.php');
	}

*/
	// Temporary Code while working on website
//	if (!isset($_SESSION['sessionID']) AND $_SERVER["REQUEST_URI"] != "/login.php" AND $_SERVER["REQUEST_URI"] != "/register.php") {

//			header( 'Location: http://apo.truman.edu/index.html' ) ;

//	}

	if (!isset($_SESSION['sessionID'])) {
		$login_logout_links = '<li class="toplast"><a href="./login.php" style="width:260px;height:15px;line-height:15px;">Login</a></li>';
	} else if ($_SESSION['sessionexec'] == 1) {
		$id = $_SESSION['sessionID'];
		$login_logout_links = "
		<li class='topmenu'><a href='#' style='width:118px;height:15px;line-height:15px;'><span>Executive</span></a>
			<ul>
				<li class='subfirst'><a href='./exec_upload.php' title='Executive 7'>Upload Document</a></li>
				<li><a href='./exec_notes.php' title='Executive 6'>Executive Pages</a></li>
				<li><a href='./service_exec_check.php' title='Executive 5'>Check Hours</a></li>
				<li><a href='./attendance_exec_check.php' title='Executive 5'>Check Attendance</a></li>
				<li><a href='./attendance_admin.php' title='Attendance'>Attendance</a></li>
				<li><a href='./committee_admin.php' title='Committee Manager'>Committee Manager</a></li>
				<!--<li><a href='./service_admin_week.php' title='Regular Service Manager'>Service Manager</a></li>-->
				<li><a href='./exec_calendar.php' title='Calendar Guide'>Calendar Guide</a></li>
				<li><a href='./exec_set_board.php' title='Edit Exec. Board'>Edit Exec. Board</a></li>
				<li><a href='./exec_member_status.php' title='Edit Statuses'>Edit Statuses</a></li>
				<!--<li><a href='./exec_taken_quiz.php' title='Risk Management Records'>Risk Management Records</a></li>
				<li><a href='./brotherhood.php' title='Brotherhood'>Brotherhood</a></li>-->
			</ul>
		</li>
		<li class='toplast'><a href='./logout.php'style='width:119px;height:15px;line-height:15px;'>Logout</a></li>";
	} else if ($_SESSION['sessionexec'] == 2 ) {
		$login_logout_links = "
		<li class='topmenu'><a href='#' style='width:118px;height:15px;line-height:15px;'><span>Executive</span></a>
			<ul>
				<li><a href='./service_exec_check.php' title='Executive 5'>Check Hours</a></li>
			</ul>
	    </li>
		<li class='toplast'><a href='logout.php'style='width:260px;height:15px;line-height:15px;'>Logout</a></li>";
	} else {
		$login_logout_links = "<li class='toplast'><a href='./logout.php'style='width:260px;height:15px;line-height:15px;'>Logout</a></li>";
	}
	$bother = "";
	// The below code leaves a message at the top of the page for users who haven't to take the risk management quiz.

//	if ($_SESSION['sessionID']) {
//		$user_id = $_SESSION['sessionID'];
//		$sql = "SELECT `risk_management`, `status` FROM `contact_information` WHERE id=$user_id LIMIT 1";
//		$result = mysql_query($sql);
//		$row = mysql_fetch_array($result);
//		if (($row[risk_management] < "2010-10-01") and ($row[status] == "Active" OR $row[status] == "Associate")) {
//			$bother = "<marquee behavior='scroll' direction='left'><font color='red'>Please take the risk management quiz! <a href='./risk_management_quiz.php'>TAKE TEST HERE!</a></font></marquee>";
//		}
//	}


	echo <<<END

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="./includes/css/style.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="./includes/css/styles.css"/>
	<!--<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/login.js"></script>-->
</head>
<body style="background-color:#EBEBEB">
<div id="holder">
<div id="top_bar">
</div>

<div id="banner">
<img src="./includes/css/css_images/header.png"/>
</div>

<div id="navigation_holder">

<div id="navigation">
<ul id="css3menu1" class="topmenu">
	<li class="topfirst"><a href="./index.php" style="width:120px;height:15px;line-height:15px;">Home</a></li>
	<li class="topmenu"><a href="#" style="width:118px;height:15px;line-height:15px;"><span>About APO</span></a>
	<ul>
		<li class="subfirst"><a href="./rushapo.php" title="About APO 1">Join APO</a></li>
		<li><a href="./history.php" title="History">History</a></li>
		<li><a href="./history_impdates.php">Important Dates</a></li>
		<li><a href="./history_awards.php" title="Awards">Awards</a></li>
		<li><a href="./history_traditions.php" title="Traditions">Traditions</a></li>
		<li><a href="./Rush_Calendar.php" title="Rush Calendar">Rush Calendar</a></li>
		<li><a href="./members_advisors.php" title="Advisors">Advisors</a></li>
	</ul>

	</li>
	<li class="topmenu"><a href="#" style="width:118px;height:15px;line-height:15px;"><span>Chapter</span></a>
	<ul>
		<li class="subfirst"><a href="#" title="Large Service"><span>Elected</span></a>
		<ul>
			<li class="subfirst"><a href="./officer_template.php?id=1" title="Elected 15">President</a></li>
			<li><a href="./officer_template.php?id=2" title="Elected 14">Large Service</a></li>
			<li><a href="./officer_template.php?id=3" title="Elected 3">Regular Service</a></li>
			<li><a href="./officer_template.php?id=6" title="Elected 13">Membership</a></li>
			<li><a href="./officer_template.php?id=4" title="Elected 12">Pledging</a></li>
			<li><a href="./officer_template.php?id=7" title="Elected 11">Sergeant at Arms</a></li>
			<li><a href="./officer_template.php?id=8" title="Elected 10">Public Relations</a></li>
			<li><a href="./officer_template.php?id=9" title="Elected 9">Recording Secretary</a></li>
			<li><a href="./officer_template.php?id=10" title="Treasurer">Treasurer</a></li>
			<li><a href="./officer_template.php?id=11" title="Scouting">Scouting</a></li>
			<li><a href="./officer_template.php?id=12" title="Elected 6">Brotherhood</a></li>
			<li><a href="./officer_template.php?id=13" title="Alumni">Alumni</a></li>
			<li><a href="./officer_template.php?id=15" title="Elected 0">Chaplain</a></li>
		</ul>

		</li>
		<li><a href="#" title="Regular Service"><span>Appointed</span></a>
		<ul>
			<li class="subfirst"><a href="./officer_template.php?id=16" title="Appointed 0">Rush</a></li>
			<li><a href="./officer_template.php?id=17" title="Appointed 7">Historian</a></li>
			<li><a href="./officer_template.php?id=25" title="Appointed 6">Fundraising</a></li>
			<li><a href="./officer_template.php?id=18" title="Appointed 5">Formal</a></li>
			<li><a href="./officer_template.php?id=19" title="Appointed 4">Inter-Chapter Relations</a></li>
			<li><a href="./officer_template.php?id=20" title="Appointed 3">Webmaster</a></li>
			<li><a href="./officer_template.php?id=26" title="Appointed 2">Red Cross</a></li>
			<li><a href="./officer_template.php?id=27" title="Appointed 1">Philanthropy</a></li>
			<li><a href="./officer_template.php?id=31" title="Appointed 8">St. Baldrick's</a></li>
			<li><a href="./officer_template.php?id=14" title="Communications">Communications Secretary</a></li>
			<li><a href="./officer_template.php?id=32" title="Appointed 10">Homecoming</a></li>
			<li><a href="./officer_template.php?id=33" title="Appointed 9">Advisor Liaison</a></li>

		</ul>

		</li>
	</ul>

	</li>
	<li class="topmenu"><a href="#" style="width:118px;height:15px;line-height:15px;"><span>Members</span></a>
	<ul>
		<li class="subfirst"><a href="./service_hours.php" title="Members 11">Hours</a></li>
		<!--<li><a href="./service_dashboard.php" title="Service Dashboard">Service Sign-Ups</a></li>-->
		<li><a href="./attendance.php" title="Attendance">Attendance</a></li>
		<!--<li><a href="./service_leader_dashboard.php" title="Project Leader Dashboard">Project Leader View</a></li>-->
		<li><a href="./members_updateinfo.php" title="Update Information">Update Information</a></li>
		<li><a href="./documents.php" title="Documents">Documents</a></li>
		<li><a href="./service_facts.php" title="Top Recorded Hours">Top Recorded Hours</a></li>
		<li><a href="./index_bylaw.php" title="APO Bylaws"><span>APO Bylaws</span></a></li>
		<li><a href="./members_list.php" title="Members Contact Information">Members Contact Information</a></li>
		<li><a href="./members_exec_list.php" title="Officers Contact Information">Officers Contact Information</a></li>
		<li><a href="./members_advisors.php" title="Advisors Contact Information">Advisors Contact Information</a></li>
		<li><a href="./members_pledging.php" title="Pledging Contact Information">Pledging Contact Information</a></li>
		<li><a href="./family_tree.php" title="Family Tree">Family Tree</a></li>
		<!--<li><a href="./officers_committee_times.php" title="Committee Times">Committee Times</a></li>-->
		<li><a href="./risk_management_quiz.php" title="Risk Management Quiz">Risk Management Quiz</a></li>
		<li><a href="./calendar.php" title="Master Calendar">Master Calendar</a></li>

	</ul>

	</li>
	$login_logout_links
</ul>
<div style="clear:both;"></div>
</div>
</div>

<div id="content_container">
END;


}



function page_footer() {



echo <<<END

<div id="footer">
	<b><a href ="./testing/">Alternate Layout</a></b>
      <p>
        2014 &copy; Alpha Phi Omega Epsilon Chapter
        <a href="http://apo.org">APO.org</a>
      </p>
      <p>
        <a href="http://truman.edu">Truman State University</a>,
        Kirksville, MO
      </p>
      <p>
       Issues? Please contact the <a href="http://apo.truman.edu/officer_template.php?id=20">Webmaster</a>
       <!--Issues? Please contact the <a href="mailto:apo.epsilon.webmaster@gmail.com?subject=Website Issue">Webmaster</a>-->
      </p>
END;

echo "
</div>

</div>

</div>
</body>
</html>

";

}
function exec_links(){

 echo "<div class='entry'><a href='quizdate.php'>Risk Management Quiz Completion date.</a><br/><a href='pledgesummary.php'>Pledge Service Summary.</a><br/><a href='summary.php'>Chapter Service Summary.</a><br/><a href='execmail.php'>Exec e-mail list</a><br/><a href='exec_file_uploader.php'>Exec website file uploader</a><br/><a href='verifyhoursspring07.php'>Check Spring 2007 Service Hours</a><br/><a href='verifyhoursspring08.php'>Check Spring 2008 Service Hours</a><br/><a href='verifyhoursfall08.php'>Check Fall 2008 Service Hours</a></div>";

}
?>