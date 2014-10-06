<?php
if((isset($_GET['browser'])) && ($_GET['browser'] == 'yes')){
		session_register('sessionPreference');
		$_SESSION['sessionPreference'] = 'browser';
}
		
if( strstr($_SERVER['HTTP_USER_AGENT'],'Android') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'BlackBerry')){
	echo("<meta http-equiv=\"REFRESH\" content=\"0;url=http://apo.truman.edu/mobile.php\">");
}else{
require_once ('layout.php');
require_once ('mysql_access.php');
$id = $_SESSION['sessionID'];

		$sql = "SELECT * FROM `apo`.`contact_information` WHERE id = '".$id."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
  				$firstname = $row['firstname'];
  				$lastname = $row['lastname'];}
page_header();
$sql = "SELECT * FROM `news_seen` WHERE who = ".$id." AND seen = 0";

if(mysql_num_rows(mysql_query($sql))>0){
	if(mysql_num_rows($result) == 1){
		$messages = "message";
	}else{
		$messages = "messages";
	}
	echo "&nbsp;{$firstname} {$lastname}, you have {$mysql_num_rows} new {$messages}. 
	<a href=\"http://apo.truman.edu/news.php\">read now</a><br/>";
}

$sql = "SELECT risk_management FROM contact_information WHERE id = ".$id." AND risk_management = '0000-00-00'";
if(mysql_num_rows(mysql_query($sql))==1){
	echo "&nbsp;you have not taken your risk management quiz, <a href=\"http://apo.truman.edu/risk_management_quiz.php\">take it now</a><br/>";
}
?>
<div id="user_meta_right"><?php 
if(date('d')%2==0){//runs every other day.
	require_once('maintenance/functions.php');//backup functions
	create_backup();//creates a backup
}
?>
</div>

<div class="content_left"><h1>Welcome</h1>

<p>Welcome to the Epsilon Chapter of Alpha Phi Omega at Truman State University.
The Epsilon Chapter of Alpha Phi Omega was founded on December 13, 1927 by ten
young men, who were all former scouts. Ever since, Epsilon has been a leader
both at the national level of the fraternity, and on the campus of Truman. Some
of the service projects that Epsilon has worked on in its first fifty years
included running Red Cross drives, putting up squirrel boxes on campus, being
tour guides for visit days, and helping out at registration. <p>Today
Epsilon is one of the strongest organizations on the Truman State University
campus. It is also the largest non-honor group on Truman's campus, with over
200 members. Epsilon's service program now includes the Red Cross Blood Drives,
Camp Silver meadows, YMCA, Ray Miller, and Twin Pines Retirement Community.
Epsilon also hosts Ugly Man on Campus every fall and St. Baldricks in the
spring!  Through friendship and service, Epsilon is poised to lead the
Kirksville and Truman communities into the twenty-first century.</div>


<div class="sidebar">

<html>
<head>
<script type="text/javascript">
<!--
var image1=new Image()
image1.src="includes/aux_images/apo_camp_1.jpg"
var image2=new Image()
image2.src="includes/aux_images/apo_camp_2.jpg"
var image3=new Image()
image3.src="includes/aux_images/apo_camp_3.jpg"
//-->
</script>
</head>
<body>
<img src="apo_camp_1.jpg" name="slide" width="100" height="100" />
<script>
<!--
//variable that will increment through the images
var step=1
function slideit(){
//if browser does not support the image object, exit.
if (!document.images)
return
document.images.slide.src=eval("image"+step+".src")
if (step<3)
step++
else
step=1
//call function "slideit()" every 2.5 seconds
setTimeout("slideit()",3500)
}
slideit()
//-->
</script>

</body>
</html>

<iframe src="https://www.google.com/calendar/b/0/embed?src=h84dpe9q6v9eft0vpgbbdmf2so%40group.calendar.google.com&amp;mode=AGENDA&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;ctz=America%2FChicago" style=" border-width:0 " width="100%" height="400" frameborder="0" scrolling="no"></iframe>
</div>
<?php page_footer(); }?>