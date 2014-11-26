<?php
require_once('layout.php');
require_once('mysql_access.php');
page_header();
echo("<div class=\"content\">");
$id = $_SESSION['sessionID'];
//$position = $_SESSION['sessionposition'];

function generalNotes(){
echo<<<HTML
<p>
Welcome to the new service sign-ups. You will find that the hours page no longer lists regular service events. They have been moved to an online sign-up form that offers several unique features. To begin, all regular service events can now be found at a single location. No more searching for google docs, they can always be found under the Members tab on "Service Sign-Ups". You may have also noticed the link on the "Hours" page. 
<p>
On the Service Sign-Ups page you will see all available service events. Once you sign-up for an event, you will be able to specify the number of seats available if you wish to drive. The default is 0. 
<p>
That's it.
<p>
Once an event you have signed up for has passed, it will display in another table on this page titled "Pending Events". All events that have not been approved by the Project Leader or automatically processed by the website will appear here.
<p>
When events become approved, your hours are recorded for you. 
<p>
Much like the Fall 2012 semester, service events will be locked at midnight on the day that they occur. 
<p>
New events become available Friday.
<p>
HTML;
}

function projectLeaderNotes(){

$sql = "SELECT * FROM service_leaders WHERE user_id = ".$id;
//$result = mysql_query($sql);
echo $sql;


$count=0;
if($count!=0){
	echo "<hr/>";


		
		echo<<<HTML
		<p>
		In addition to the above Project Leaders have the "Project Leader View". 
		<p>
		On this page you will be able to view current attendance for events yet to come. You will be able to see each person's contact information, and how many seats available in their car if they choose to drive.
		<p>
		At midnight on the day that the event is scheduled to occurr these events will transition to "Past" events. At this point, viewing the event will return a roster of persons who had signed up for it. You will be able to alter the number of hours to be recorded per individual or mark them as absent altogether. 
		<p>
		Cancelled events will also be listed here. You cannot view any information for a canceled event.
		<p>
		HTML;
	}	
}

function regularServiceNotes(){	

}


generalNotes();
projectLeaderNotes();

//if($position == "VP of Regular Service"){
//if($position == "Webmaster"){
//	regularServiceNotes();
//}*/
echo"</div>";
page_footer();

?>