<?php
require_once ('session.php');
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
        <div class="large-10 medium-9 small-12 column large-centered medium-centered">
            <h2>Alpha Phi Omega</h2>
            <h3>Epsilon Chapter</h3>
            <br>
            <p>Welcome to the Epsilon Chapter of Alpha Phi Omega at Truman State University. The Epsilon Chapter of Alpha Phi Omega was founded on December 13, 1927 by ten young men, who were all former scouts. Ever since, Epsilon has been a leader both at the national level of the fraternity, and on the campus of Truman. Some of the service projects that Epsilon has worked on in its first fifty years included running Red Cross drives, putting up squirrel boxes on campus, being tour guides for visit days, and helping out at registration.
                <br><br>
            Today Epsilon is one of the strongest organizations on the Truman State University campus. It is also the largest non-honor group on Trumans campus, with over 200 members. Epsilons service program now includes the Red Cross Blood Drives, Camp Silver Meadows, YMCA, Ray Miller, and Twin Pines Retirement Community. Epsilon also hosts a philanthropy event every fall and St. Baldricks in the spring! Through friendship and service, Epsilon is poised to lead the Kirksville and Truman communities into the twenty-first century.
            <br>
            </p>
            <h6> New pledges, follow <a href="./register.php">this link</a> to register for the site!</h6>

        </div>
    </div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>