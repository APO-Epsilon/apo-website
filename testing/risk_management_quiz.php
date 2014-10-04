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

<?php
function print_question($question) {

    echo $question[0] . ". " . $question[1] . "<br/>";
    $i = 2;

    while ($i < count($question)) {
        echo "<input type='radio' name='question[$question[0]]' value='$i'> $question[$i] <br/>";
        $i = $i + 1;
    }
    echo "<br/>";
}

function score_quiz($right_answers, $answers) {
    $score = 0;
    $missed = array();
    foreach ($answers as $number => $answer) {
        if ($right_answers[$number] == $answer) {
            $score = $score + 1;
        } else {
            $missed[] = "$number";
        }
    }

    echo "Score: " . $score . "<br>";

    if ($score >= 11) {
        $user_id = $_SESSION['sessionID'];
        $sql = "UPDATE `contact_information` SET `risk_management`=NOW() WHERE id='$user_id'";
        $result = mysql_query($sql);
        echo "<h1 style='color: purple'>You have passed the quiz!</h1>";
    } else {
        echo "You missed too many questions.  Please try again.  You were wrong on questions: ";

        foreach ($missed as $x => $y) {
            echo "$y, ";
        }
    }
}

$quiz = array();
$quiz[] = array("1","For what reasons or reasons is the Risk Management policy in place and enforced?", "To protect the Chapter", "To protect the Individual", "All of the Above");

$quiz[] = array("2","Who is responsible for any personal property utilized in fraternity activities?", "The Chapter", "The individual providing item(s)","the national headquarters of Alpha Phi Omega","Pledges");

$quiz[] = array("3","What is the difference between 'unofficial' and 'official' Alpha Phi Omega functions?","'Official' Chapter events are not secret events on Facebook.","Happenings at 'unofficial' Chapter events cannot affect an individual's standing within the Chapter.","Alcohol can be served at 'unofficial' Chapter events if off-campus.","There is no such thing as an 'unofficial' Alpha Phi Omega function, so there is no difference.");

$quiz[] = array("4","True or False? A guest of a brother at an official Alpha Phi Omega event doesn't have to act in accordance with our bylaws or risk management policy.", "True", "False");

$quiz[] = array("5","When questioned by the media or others outside the Chapter, how should members respond?", "'No comment' and then refer person to Chapter's current President.", "Tell his/her version of events.", "Tell what was heard from police, medics, or other officials regarding incident.", "Refer person to Public Relations chair or Sergeant-at-Arms.");

$quiz[] = array("6","Alpha Phi Omega forbids hazing. Which of the following do/does NOT qualify as hazing?", "An activity which endangers the physical safety of a member.", "An activity producing mental or physical discomfort.", "An activity causing embarrassment, fright, humiliation or ridicule.", "All of the above constitute hazing.");

$quiz[] = array("7", "What happens if a member of Alpha Phi Omega violates any risk management policy?", "The individual will be suspended immediately","If no member of the executive board saw it, no actions will be taken", "Any member of the organization may file a complaint to the President, and actions will be taken from there.", "The individual is automatically sentenced to 5 extra hours of service.");

$quiz[] = array("8", "In reference to personal vehicles in conjunction with Alpha Phi Omega activities, individuals should_____________.", "allow others to operate the vehicle.", "restrict alcohol intake and presence to the backseat.", "obey all motor vehicle laws", "race other vehicles on the road.");

$quiz[] = array("9", "Regarding alcohol at select off-campus Chapter events, where can it be served/consumed?", "In the car, on the way to or from Chapter event", "At same open table as alternative beverages and food items.", "In a separate room from main function", "Out of sight of under-age members");

$quiz[] = array("10", "In the event of the President being unavailable during an emergency, the order to which his or her duties should fall is (first to last):", "First Vice President Large Service, First Vice President Regular Service, Recording Secretary, Second Vice President of Membership, and Sergeant @ Arms.", "Sergeant @ Arms, First Vice President Large Service, First Vice President Regular Service, Recording Secretary, and Second Vice President of Membership", "University President Troy Paino, First Vice President Regular Service, Public Relations Chair, Second Vice President of Membership, and Sergeant @ Arms", "Recording Secretary, First Vice President Regular Service, Second Vice President of Membership, First Vice President Large Service, and Sergeant @ Arms");

$quiz[] = array("11", "If you are unsure of whether an area is off-limits (i.e. a roof), should you enter this area?", "Yes", "No");

$right_answers = array();
$right_answers[1] = 4;
$right_answers[2] = 3;
$right_answers[3] = 5;
$right_answers[4] = 3;
$right_answers[5] = 2;
$right_answers[6] = 5;
$right_answers[7] = 4;
$right_answers[8] = 4;
$right_answers[9] = 4;
$right_answers[10] = 2;
$right_answers[11] = 3;

function passed_quiz() {
    if (isset($_SESSION['sessionID'])) {
        $user_id = $_SESSION['sessionID'];
        $sql = "SELECT `risk_management` FROM `contact_information` WHERE id='$user_id'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if ($row['risk_management'] != "0000-00-00") {
            return true;
        }
        else {
            return false;
        }
    }
}

function print_quiz($quiz,$right_answers) {
    echo "<p>You are required to pass a risk management quiz once a year.  To pass the quiz, you must answer all 11 questions correctly.  You can take the quiz as many times as you need.  If you want to read the Risk Management policy you can find it here: <a href='http://apo.truman.edu/Sergeant%20At%20Arms%20Info/APO%20Epsilon%20-%20Risk%20Mgmt.pdf'>Risk Management</a>.</p>";
    echo "<form method='post'>";
    foreach ($quiz as $quiz_item) {
        print_question($quiz_item);
    }
    echo "<input type='submit' value='Submit'/></form>";
}

page_header();
if(!isset($_SESSION['sessionID'])){
    die("please login to access this page");
}else{
echo "<div class='content'>";

if (isset($_POST['question'])) {
    score_quiz($right_answers, $_POST['question']);
}

passed_quiz();

if (!passed_quiz()) {
    print_quiz($quiz,$right_answers);
} else {
    echo "Congratulations. You have passed the risk management quiz.";
}
}
?>
    </div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>