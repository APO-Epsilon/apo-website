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
    if (passed_quiz()) {
        echo "<h2>You have passed the quiz!</h2>";
    } else {
		echo "<h2>Risk Management Quiz</h2>";
		if (count($_POST) > 0) {
			grade_quiz();
		}
		else {
			show_quiz();
		}
    }
}

?>

<?php

function passed_quiz() {
    include ('mysql_access.php');
    if (isset($_SESSION['sessionID'])) {
        $user_id = $_SESSION['sessionID'];
        $sql = "SELECT `risk_management` FROM `contact_information` WHERE id='$user_id'";
        $result = $db->query($sql);
        $row = mysqli_fetch_array($result);
        if ($row['risk_management'] != "0000-00-00") {
            return true;
        }
        else {
            return false;
        }
    }
}

function grade_quiz() {
	
	$score = 0;
	
	//questions
	if(isset($_POST["1"])) {
		if($_POST["1"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : <br>";
			echo "Correct Answer : <br>";
			echo "<br>";
		}
	}
	if(isset($_POST["2"])) {
		if($_POST["2"]==4){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["3"])) {
		if($_POST["3"]==3){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["4"])) {
		if($_POST["4"]==4){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["5"])) {
		if($_POST["5"]==3){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["6"])) {
		if($_POST["6"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["7"])) {
		if($_POST["7"]==1){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["8"])) {
		if($_POST["8"]==3){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["9"])) {
		if($_POST["9"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["10"])) {
		if($_POST["10"]==4){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["11"])) {
		if($_POST["11"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["12"])) {
		if($_POST["12"]==1){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["13"])) {
		if($_POST["13"]==4){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["14"])) {
		if($_POST["14"]==1){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["15"])) {
		if($_POST["15"]==3){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["16"])) {
		if($_POST["16"]==4){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["17"])) {
		if($_POST["17"]==1){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["18"])) {
		if($_POST["18"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["19"])) {
		if($_POST["19"]==3){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["20"])) {
		if($_POST["20"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["21"])) {
		if($_POST["21"]==4){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["22"])) {
		if($_POST["22"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["23"])) {
		if($_POST["23"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["24"])) {
		if($_POST["24"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["25"])) {
		if($_POST["25"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["26"])) {
		if($_POST["26"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}		
	if(isset($_POST["27"])) {
		if($_POST["27"]==2){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["28"])) {
		if($_POST["28"]==1){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["29"])) {
		if($_POST["29"]==1){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}
	if(isset($_POST["30"])) {
		if($_POST["30"]==1){
			$score++;
		}
		else {
			//show correct answer for question
		}
	}

	//results
	echo "Your Score is: " . $score . " of 20<br>";
	if($score>19) {
		echo "You passed!";
		include ('mysql_access.php');
		if (isset($_SESSION['sessionID'])) {
			$user_id = $_SESSION['sessionID'];
			$timestamp = date('Y-m-d');
			$sql = "UPDATE `apo` . `contact_information` SET `risk_management` = '$timestamp' WHERE id='$user_id'";
			$result = $db->query($sql);
    }
	}
	else {
		echo "Sorry, you must score 20/20. Please try again.";
	}
}

function show_quiz() {
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM questions LIMIT 20");?>

    <br>
    <form name="quiz" method='post' id='quiz_form'>
        <?php 
		$count = 0;
		while($result=mysqli_fetch_array($response)){ 
		$count++; ?>
        <div id="question_<?php echo $result['id'];?>" class='questions'>
        <h3 id="question_<?php echo $result['id'];?>"><?php echo $count.". ".$result['question_name'];?></h3>
		<h4 id="answer_<?php echo $result['id'];?>"><?php echo $result['answer'];?></h4>
        <div class='align'>
        <input type="radio" value="1" id='radio1_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'>
        <label id='ans1_<?php echo $result['id'];?>' for='1'><?php echo $result['answer1'];?></label>
        <br/>
        <input type="radio" value="2" id='radio2_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'>
        <label id='ans2_<?php echo $result['id'];?>' for='1'><?php echo $result['answer2'];?></label>
        <br/>
        <input type="radio" value="3" id='radio3_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'>
        <label id='ans3_<?php echo $result['id'];?>' for='1'><?php echo $result['answer3'];?></label>
        <br/>
        <input type="radio" value="4" id='radio4_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'>
        <label id='ans4_<?php echo $result['id'];?>' for='1'><?php echo $result['answer4'];?></label>
        <input type="radio" checked='checked' value="5" style='display:none' id='radio4_<?php echo $result['id'];?>' name='<?php echo $result['id'];?>'>
        </div>
        <br/>
        </div>
        <?php }?>
		<input type="submit" value="Submit">
    </form>
    <div id='result'>
    </div>
<?php } ?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
