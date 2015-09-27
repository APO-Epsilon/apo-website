<?php
require_once ('session.php');
require_once ('../mysql_access.php');
require_once ('../get_photo.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>
    <div class="row">
    <ul class="large-block-grid-2 small-block-grid-1">

        <div class="small-12 columns">
          <h1 class="text-center">Conference Committee</h1>
        </div>

      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
      		<img src="../img/https://mail.google.com/mail/u/3/#inbox/1500ab377624d206?projector=1" width="125" style="display: block; margin-left: auto; margin-right: auto;">
      		<h4 class="text-center">
            Conference Chair
            <br>
          </h4>
          <p class="text-center">
            Joe Hall
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->

      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Conference Advisor
            <br>
          </h4>
          <p class="text-center">
            David Gilbert
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->
            <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Logistics Chair
            <br>
          </h4>
          <p class="text-center">
            Ashley Banze
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->

        <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Public Relations
            <br>
          </h4>
          <p class="text-center">
            Emily Leddin
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->
      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Treasurer
            <br>
          </h4>
          <p class="text-center">
            Josh Bright
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->
      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Workshops
            <br>
          </h4>
          <p class="text-center">
            Valerie Frerichs
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->
      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Brotherhood
            <br>
          </h4>
          <p class="text-center">
            Trista Sullivan
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->
      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Bidding Committee Liason
            <br>
          </h4>
          <p class="text-center">
            Libby Moser
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->
      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Brother Housing
            <br>
          </h4>
          <p class="text-center">
            Molly Turner and Rick Cazzato Jr.
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->
      <!-- This is the part that gets repeated for each person -->
        <div class="small-12 medium-6 columns">
          <img src="../img/unknown.jpg" width="125" style="display: block; margin-left: auto; margin-right: auto;">
          <h4 class="text-center">
            Ceremony
            <br>
          </h4>
          <p class="text-center">
            Taylor Demien
            <br>
            <a href="mailto:apo.epsilon.conferencechair@gmail.com">
              apo.epsilon.conferencechair@gmail.com
            </a>
          </p>
        </div>
      <!-- This is the end of the part that gets repeated for each person -->

  </ul>
  </div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
