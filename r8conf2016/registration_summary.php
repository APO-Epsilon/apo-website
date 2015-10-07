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


<div class="row">
    <div class="medium-10 small-12 columns">

<?php
    function show_exec() {
        echo "exec";
    }
    
    function show_public() {
        echo "public";
    }
    
    $exec_page = True;
    $active_page = False;
    $public_page = True;
    require_once('permissions.php');

?>
    </div>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
