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
      		<img src="https://gm1.ggpht.com/CBpVjn72k7fUu-LEig8xbq-9Xmh1gpqxeir0fwAi4MNa2YZqjcqpGA_GA2WU1OZxBUlDC4gN82W7iHlPgUkpF02onhLR_WQkFHOZkPVk6-JEYsef1Iwmcz_GfWHLHSfOwEg5zHJTdZ-nJDOXAJm2CoVDN2_V1LZiNG2X1MJt39c_Kmpp_-_lS8uoD-BJC-k0sKrCygDqpVdmxRjJYN78O_fv8KCSM_26QuSEdku-DaNt2vhbjsnTu4bgr5PbspSDhkDix8Vk9YV7Z2f01g2ANOy7il1hP82Xa_iPSbk2gnNRzp41ZKhKeCduqFlJhXU5BPkSv8J-JaZtgTErbyYO4ls7eI1EZTLjdpfC9zKfn3YDJpamE6zZ6fQD34q1-6aThfOL9jEgjK-rgZPIUa8effnkQtfxwq9Ul-6lUMpHGgSvg6JtpMNV2xHM1medw4zbdy4DLgQb2VZ7oyDYYvB12JhuMu9mGgpzhlpE5robMU5gXZAAEtYdydKfjZxIANpDeYz3omh3NlzuwYnhL-kp0VlUmgkoPNhkq81KzD2RWKi4qejsYoL689qAC31iF-znWmVYYF5xcJTCOgglGyUu-rxT2hjhg-1hfjrKN1SmT6AZCVvze0o7OL9q2uD4et8NIE8_nTYM7RtrAN8fqw5dDsyl8PM=w686-h914-l75-ft" width="125" style="display: block; margin-left: auto; margin-right: auto;">
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
