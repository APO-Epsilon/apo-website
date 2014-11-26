<?php
require_once ('session.php');
require_once ('mysql_access.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body>
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->
<div class="row">

<?php function passed_quiz() {
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
if (passed_quiz()) {
    echo "<h2>You have passed the quiz!</h2>";
} else {
    echo "<h1>You have <b>NOT</b> passed the quiz!</h1>";
}?>

<?php $response=mysql_query("SELECT * FROM questions");?>

<br>
<form method='post' id='quiz_form'>
    <?php while($result=mysql_fetch_array($response)){ ?>
    <div id="question_<?php echo $result['id'];?>" class='questions'>
    <h3 id="question_<?php echo $result['id'];?>"><?php echo $result['id'].".".$result['question_name'];?></h3>
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
    <input type="button" id='next<?php echo $result['id'];?>' value='Next!' name='question' class='butt'/>
    </div>
    <?php }?>
</form>
<div id='result'>
</div>
<script src="./js/watch.js"></script>
<script src="./js/quiz.js"></script>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>