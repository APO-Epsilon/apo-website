<?php
require_once ('layout.php');
require_once ('mysql_access.php');
$id = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `apo`.`contact_information` WHERE id = '".$id."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
  				$firstname = $row['firstname'];
  				$lastname = $row['lastname'];}
  	/*	$sql1 = "SELECT * FROM `responses` WHERE user_id=".$id."";
  			$result1 = mysql_query($sql1);
  				while($row1 = mysql_fetch_array($result1)){
  					$unanswered[$a] = $row1['id'];
  		$sql2 = "SELECT COUNT(*) FROM `polls` WHERE id=".$unanswered[$a]." AND old = 0";
  			$result2 = mysql_query($sql2);
  				while($row2 = mysql_fetch_array($result2)){
  					$unanswered_polls = $row['COUNT(*)'];
  						if($unanswered_polls[$b] >= 1){echo('You have one or more unanswered polls! <a href="http://apo.truman.edu/polls.php">Answer now</a>');}}}*/
page_header();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css3menu1/style.css" type="text/css" />

</head>
<body style="background-color:#EBEBEB">
<ul id="css3menu1" class="topmenu">
	<li class="topfirst"><a href="#" style="width:259px;height:15px;line-height:15px;"><span>Epsilon</span></a>
	<ul>
		<li class="subfirst"><a href="http://apo.truman.edu/epsilon_bylaw.php">Bylaws</a></li>
		<li><a href="http://apo.truman.edu/epsilon_risk.php">Risk Management</a></li>
		<li><a href="http://apo.truman.edu/epsilon_jboard.php">Judicial Board</a></li>
	</ul>

	</li>
	<li class="topmenu"><a href="#" style="width:257px;height:15px;line-height:15px;"><span>National</span></a>
	<ul>
		<li class="subfirst"><a href="http://apo.truman.edu/national_bylaws.php">Bylaws</a></li>
		<li><a href="http://apo.truman.edu/national_risk.php">Risk Management</a></li>
	</ul>

	</li>
	<li class="toplast"><a href="http://apo.truman.edu/student_conduct.php" style="width:260px;height:15px;line-height:15px;">Student Code of Conduct</a></li>
</ul>


<p style="display:none"><a href="http://css3menu.com/">CSS3 Menu Top Css3Menu.com</a></p>



<div style="clear:both" />
<div id="user_meta_right"><?php
if($id){
//echo('Welcome '.$firstname.' '.$lastname.'&nbsp;&nbsp;<a href="http://apo.truman.edu/logout.php">Logout</a>');}else{
//<a href="http://apo.truman.edu/login.php">Login</a>?>
<? }?>
</div>
<div class="content_left"><!--<a href="http://bit.ly/wo2B7s"><img src="redcross.jpg" width ="100"/><br /><h4>Click here to donate<br />April 3rd or 4th</h4></a><br />-->
<h1>Bylaws</h1>
<p>Bylaws are above</div>

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

</div>
<?php
page_footer();
?>