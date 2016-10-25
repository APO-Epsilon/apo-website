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
      $user_id = $_SESSION['sessionID'];
      include('mysql_access.php');
      $response=$db->query("SELECT position FROM contact_information WHERE id = $user_id");
      $result=mysqli_fetch_array($response);
	  //include results for the sarge and webmaster
      if ($result['position'] == 'Sergeant at Arms' or $result['position'] == 'Webmaster') {
		?>
		<audio id="myTune">
			<source src="RISK.wav">
		</audio>
 
		<button onclick="document.getElementById('myTune').play()">RISK ALERT</button>
		<?php
        echo '<h1>PASSED THE QUIZ</h1><br>';
        show_pass();
        echo '<h1>NEED TO PASS THE QUIZ</h1><br>';
        show_fail();
      }
      else{
        echo '<h2>You have passed the quiz!</h2>';
		echo '<h3>As a reward you have unlocked : RISK alert button<br>';
		?>
		<audio id="myTune">
			<source src="RISK.wav">
		</audio>
 
		<button onclick="document.getElementById('myTune').play()">RISK ALERT</button>
		<?php
      }
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
function show_pass() {
	//count may be simplified with SQL query
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE risk_management != '0000-00-00' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>Last Name</td><td>First Name</td><td>Date Passed</td></tr>';
    while($result=mysqli_fetch_array($response)){
	//leave out members who do not need this quiz 
      if ( ($result['status'] != 'Alumni') and ($result['status'] != 'Advisor') and ($result['status'] != 'Inactive') ) {
        echo '<tr><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['risk_management'] . '</td></tr>';
        $count++;
      }
    }
    echo '</table>';
    echo $count . ' people have passed the quiz.<br><br>';
}

function show_fail() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE risk_management = '0000-00-00' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td></tr>';
    while($result=mysqli_fetch_array($response)){
	//leave out members who do not need this quiz
      if ( ($result['status'] != 'Alumni') and ($result['status'] != 'Advisor') and ($result['status'] != 'Pledge') ) {
        echo '<tr><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email'] . '</td></tr>';
        $count++;
      }
    }
    echo '</table>';
    echo $count . ' people have not passed the quiz.<br>';
  }
  
function passed_quiz() {
    include ('mysql_access.php');
	//check if the user has passed the quiz
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
	//This part of the code is ridiculously hardcoded for now. Should use SQL to check for correct answers.
	$score = 0;
	//questions
	if(isset($_POST["1"])) {
		if($_POST["1"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What can the chapter not sell?<br>";
			echo "Correct Answer : Alcoholic beverages<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["2"])) {
		if($_POST["2"]==4){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What should be available when alcoholic beverages are served?<br>";
			echo "Correct Answer : All of the above<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["3"])) {
		if($_POST["3"]==3){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Who is responsible for guests at chapter functions?<br>";
			echo "Correct Answer : All members<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["4"])) {
		if($_POST["4"]==4){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Who cannot be served alcoholic beverages?<br>";
			echo "Correct Answer : All of the above<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["5"])) {
		if($_POST["5"]==3){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What happens to members who violate the risk management policy?<br>";
			echo "Correct Answer : J-Board<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["6"])) {
		if($_POST["6"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : If an event is called unofficial by a member, what does that mean in the eyes of the law, the campus, and the fraternity?<br>";
			echo "Correct Answer : It's official<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["7"])) {
		if($_POST["7"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Who is required to wear a seatbelt?<br>";
			echo "Correct Answer : State's laws<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["8"])) {
		if($_POST["8"]==3){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Which is not in the risk management policy regarding transportation?<br>";
			echo "Correct Answer : Starting with a full tank of gas<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["9"])) {
		if($_POST["9"]==2){
			$score++;
		}
		else {
			//show correct answer for questio
			echo "Question : What cannot be purchased with fraternity funds?<br>";
			echo "Correct Answer : Alcohol<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["10"])) {
		if($_POST["10"]==4){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Which of the following laws and regulations applies to members?<br>";
			echo "Correct Answer : All of the above<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["11"])) {
		if($_POST["11"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Who is the spokesperson for the chapter?<br>";
			echo "Correct Answer : The president<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["12"])) {
		if($_POST["12"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Who takes over for the president?<br>";
			echo "Correct Answer : VP of large service<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["13"])) {
		if($_POST["13"]==4){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What are you supposed to do during a chapter emergency?<br>";
			echo "Correct Answer : All of the above<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["14"])) {
		if($_POST["14"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What should you do if questioned?<br>";
			echo "Correct Answer : Say no comment<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["15"])) {
		if($_POST["15"]==3){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What does APO say about hazing?<br>";
			echo "Correct Answer : Hazing is forbidden<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["16"])) {
		if($_POST["16"]==4){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What is a violation of the national fraternity membership policies?<br>";
			echo "Correct Answer : All of the above<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["17"])) {
		if($_POST["17"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What happens if I loan my crockpot and it breaks?<br>";
			echo "Correct Answer : I have to pay for damages<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["18"])) {
		if($_POST["18"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What should I do if the chainsaw I'm supposed to use during camp service has a damaged wire?<br>";
			echo "Correct Answer : You can't use it<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["19"])) {
		if($_POST["19"]==3){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : What is not allowed on my personal facebook page?<br>";
			echo "Correct Answer : A negative post about APO<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["20"])) {
		if($_POST["20"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Where can I post ritual information<br>";
			echo "Correct Answer : Nowhere<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["21"])) {
		if($_POST["21"]==4){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : If I see a negative yak about APO what do I do?<br>";
			echo "Correct Answer : All of the above<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["22"])) {
		if($_POST["22"]==2){
			$score++;
		}
		else {
			//show correct answer for questio
			echo "Question : If I'm taking a picture with APO letters, can I flip the bird?<br>";
			echo "Correct Answer : No<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["23"])) {
		if($_POST["23"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : How often does instruction need to be given on risk management?<br>";
			echo "Correct Answer : Once a year<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["24"])) {
		if($_POST["24"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Do unofficial APO functions exist?<br>";
			echo "Correct Answer : No<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["25"])) {
		if($_POST["25"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Can there be alcohol at rush?<br>";
			echo "Correct Answer : No<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["26"])) {
		if($_POST["26"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Can I wear my letters while drinking alcohol?<br>";
			echo "Correct Answer : No<br>";
			echo "<br>";
		}
	}		
	if(isset($_POST["27"])) {
		if($_POST["27"]==2){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Is the national fraternity a dry organization?<br>";
			echo "Correct Answer : No<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["28"])) {
		if($_POST["28"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Is Epsilon a dry organization?<br>";
			echo "Correct Answer : Yes<br>";
			echo "<br>";

		}
	}
	if(isset($_POST["29"])) {
		if($_POST["29"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Do members need to use proper safety equipment?<br>";
			echo "Correct Answer : Yes<br>";
			echo "<br>";
		}
	}
	if(isset($_POST["30"])) {
		if($_POST["30"]==1){
			$score++;
		}
		else {
			//show correct answer for question
			echo "Question : Does Epsilon need to provide sober drivers?<br>";
			echo "Correct Answer : Yes<br>";
			echo "<br>";
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
	//display the actual quiz, pick 20 random questions from the 30 in the database
    $response=$db->query("SELECT * FROM questions ORDER BY rand() LIMIT 20");?>
    <br>
    <form name="quiz" method='post' id='quiz_form'>
        <?php 
		$count = 0;
		while($result=mysqli_fetch_array($response)){ 
		$count++; ?>
        <div id="question_<?php echo $result['id'];?>" class='questions'>
        <h3 id="question_<?php echo $result['id'];?>"><?php echo $count.". ".$result['question_name'];?></h3>
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
