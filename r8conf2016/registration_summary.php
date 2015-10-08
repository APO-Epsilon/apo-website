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

<?php
    function show_exec() {
        //Let's get a whole bunch of data
        include('../mysql_access.php');
        //Let's count all the registrants
        $sql = "SELECT COUNT(*) AS num_reg FROM conf_contact_information;";
        $result = $db->query($sql);
        $row = mysqli_fetch_assoc($result);
        $num_reg = $row['num_reg'];

        //Summarize those T-Shirt sizes
        $sql = "SELECT shirt, COUNT(id) AS num_shirts FROM conf_contact_information GROUP BY shirt ORDER BY FIELD(shirt, 'S', 'M', 'L', 'XL', '2XL', '3XL');";
        $result = $db->query($sql);
        $shirt_sizes = "<p>";
        while($row = mysqli_fetch_assoc($result)) {
            $shirt_sizes .= $row['shirt'] . ": " . $row['num_shirts'] . "<br>";
        }
        $shirt_sizes .= "</p>";

        ?>

    <div class="small-12 columns">
        <h1>Registration Summary</h1>
        <h3>Number registered: <?php echo $num_reg ?></h3>
        <h3>Shirt Sizes</h3>
        <?php echo $shirt_sizes ?>



        <?php
    }
    
    function show_public() {
        ?>

    <div class="small-12 columns">
        <h1>Oops</h1>
        <p>It appears that you're in the wrong place. This page is only for the Conference Chair</p>
    </div>

        <?php
    }
    
    $exec_page = True;
    $active_page = False;
    $public_page = True;
    require_once('permissions.php');

?>

</div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
