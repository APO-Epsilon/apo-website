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
$exec_page = True;
$active_page = True;
$public_page = False;
require_once('permissions.php');

function show_active() {
  $user_id = $_SESSION['sessionID'];
    if ($user_id ==  '1020' or $user_id == '857') {
      echo 'PASSED THE QUIZ<br>';
      show_pass();
      echo 'NEED TO PASS THE QUIZ<br>';
      show_fail();
    }
    else{
      echo 'You are not allowed to view this page.';
    }
}

?>

<?php

function show_pass() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE risk_management != '0000-00-00' ORDER BY lastname");
    while($result=mysqli_fetch_array($response)){ 
      if ( ($result['status'] != 'Alumni') and ($result['status'] != 'Advisor') and ($result['status'] != 'Inactive') ) {
        echo $result['lastname'] . ', ' . $result['firstname'] . '  passed on ' . $result['risk_management'] . '<br>';
        $count++;
      }
    }
    echo $count . ' people have passed the quiz.<br><br>';
}
function show_fail() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE risk_management = '0000-00-00' ORDER BY lastname");
    while($result=mysqli_fetch_array($response)){ 
      if ( ($result['status'] != 'Alumni') and ($result['status'] != 'Advisor') ) {
        echo $result['lastname'] . ', ' . $result['firstname'] . '<br>';
        $count++;
      }
    }
    echo $count . ' people have not passed the quiz.<br>';
  } ?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
