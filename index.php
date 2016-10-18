<?php
require_once ('session.php');
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

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="row">
	<?php
		include('mysql_access.php');
		$response=$db->query("SELECT sum(hours) FROM recorded_hours");
		$result=mysqli_fetch_array($response);
		echo "<h2> This semester, Epsilon has completed " . $result['sum(hours)'] . " hours!</h2>";
    ?>
    <div class="large-8 medium-6 small-12 columns">
    <?php require_once('editable_page.php'); ?>
        </div>
        <div class="large-4 medium-6 small-12 columns">
            <div class="fb-like-box" data-href="https://www.facebook.com/apo.epsilon" data-height="600" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="true" data-show-border="false">
            </div>
        </div>
    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
