<?php
require_once('session.php');
require_once('mysql_access.php');
require_once('get_photo.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
    <script src="/js/vendor/jquery.js"></script>
</head>

<body class="slide" data-type="background" data-speed="5">
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>
    <div class="row">
    <div class="small-12 columns"><h2>Our Active Members</h2><p>Click on a pledge class to reveal those members</p></div><br><br><br><br><br><br>
        <?php
          $sql = "SELECT DISTINCT pledgeyear FROM contact_information WHERE pledgeyear<>\"\" ORDER BY pledgeyear ASC;";
          $yearResult = $db->query($sql);
          while($yearArray = mysqli_fetch_array($yearResult)){
            $year = $yearArray['pledgeyear'];
            $sql = "SELECT DISTINCT pledgesem FROM contact_information WHERE pledgeyear=\"$year\" AND pledgesem<>\"\" ORDER BY pledgesem DESC;";
            $semResult = $db->query($sql);
            while($semArray = mysqli_fetch_array($semResult)){
              $sem = $semArray['pledgesem'];
              echo "<div class=\"small-12 columns small-centered text-center\"><button id=\"{$sem}{$year}button\">$sem $year</button></div>";
              echo "<ul id=\"{$sem}{$year}\" class=\"large-block-grid-6 medium-block-grid-4 small-block-grid-2\" style=\"display: none;\">";
              $sql = "SELECT id, firstname, lastname FROM contact_information WHERE pledgeyear=\"$year\" AND pledgesem=\"$sem\" AND status<>\"Alumni\" ORDER BY lastname ASC;";
              $activeResult = $db->query($sql);
              while($active = mysqli_fetch_array($activeResult)){
                $id = $active['id'];
                $firstname = $active['firstname'];
                $lastname = $active['lastname'];
                $activePhotoLink = getPhotoLink($id);
                echo "<li><div class=\"small-12 small-centered columns text-center\"><img src=\"{$activePhotoLink}\" width=\"75\" height=\"100\"><br><p>$firstname $lastname</p></div></li>\n";
              }
              echo "</ul>";
              echo "<script type=\"text/javascript\">";
              echo "\$(document).ready(function(){";
              echo "\$(\"#{$sem}{$year}button\").click(function(){";
              echo "if(\$(\"#{$sem}{$year}\").css(\"display\") == \"none\"){";
              echo "\$(\"html,body\").animate({scrollTop: $(\"#{$sem}{$year}button\").offset().top}, 600);";
              echo "}";
              echo "\$(\"#{$sem}{$year}\").slideToggle(600);";
              echo "});";
              echo "});";
              echo "</script>";
            }
          }
        ?>
    </div>
    <div id="footer"><?php include 'footer.php';?></div>
</body>
</html>
