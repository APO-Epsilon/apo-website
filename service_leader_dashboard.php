<?php
require_once ('session.php');
require_once ('mysql_access.php');
require_once ('service_leader_functions.php');
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
<?php
$id = $_SESSION['sessionID'];
$position = $_SESSION['sessionposition'];
if($position != "Webmaster" && $position != "VP of Regular Service"){
  //die("this page is under construction.");
}
echo("<div class=\"row\"><div class=\"small-12 columns\">");

if (isset($_POST['log']) && ('process' == $_POST['log'])) {
    process_log();
}else{
  if(isset($_GET['p'])){
    processAttendance($_GET['d'],$_GET['o']);
  }elseif(isset($_GET['d'])){
    displayView($_GET['d']);
  }elseif(isset($_POST['addNew']) && ('continue' == $_POST['addNew'])){
    processNew();
  }else{
    displayActive(1);
    displayActive(0);
    displayActive(2);
  }
}
echo("</div></div>");
?>
   <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
