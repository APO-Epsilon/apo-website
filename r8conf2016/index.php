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
    <div class="large-8 medium-8 small-12 columns">
        <div class="row">
            <div class="small-12 columns">
                <?php require_once('editable_page.php'); ?>
                <br><br>
            </div>
            <div class="large-4 medium-6 small-6 columns">
                <a href="register.php" class="button expand">Register</a>
            </div>
            <div class="large-4 medium-6 small-6 columns end">
                <a href="login.php" class="button expand">Login</a>
            </div>
        </div>
    </div>
    <div class="large-4 medium-4 small-12 columns">
        <a class="twitter-timeline" href="https://twitter.com/APORegionals16" data-widget-id="565319444856328196">Tweets by @APORegionals16</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
</div>
<?php
    include('../mysql_access.php');
    //All them chapters coming
    $sql = "SELECT RTRIM(CONCAT(chapter1, ' ', chapter2, ' ', chapter3)) AS chapter, COUNT(id) AS num_chapter FROM conf_contact_information GROUP BY chapter ORDER BY num_chapter DESC;";
    $result = $db->query($sql);
    $chapters_data = "";
    while($row = mysqli_fetch_assoc($result)) {
        $chapters_data .= "{'Chapter Name': '" . $row['chapter'] . "', 'Number Registered': " . $row['num_chapter'] . "},\n";
    }
    $chapters_data = rtrim($chapters_data, ",\n");
?>
<div class="row">
    <div class="medium-8 small-12 medium-centered columns">
        <div id="chapterdiv" style="height: 30%;"></div>
    </div>
</div>
<script src="/js/d3/d3.min.js"></script>
<script src="/js/d3plus/d3plus.min.js"></script>
<script>

    var chapterdata = [
            <?php echo $chapters_data; ?>
        ]

    var chaptervisualization = d3plus.viz()
        .container("#chapterdiv")
        .data(chapterdata)
        .type("bar")
        .id("Chapter Name")
        .x({"value": "Chapter Name", "grid": false, "ticks": {"size": 0}})
        .y({"value": "Number Registered"})
        .title("Chapter Registrations")
        .draw()

</script>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
