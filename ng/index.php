<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
    <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
          <title>AngularJS Authentication App</title>

           <link href="css/bootstrap.min.css" rel="stylesheet">
<!--         <link href="css/custom.css" rel="stylesheet">-->

          <link rel="stylesheet" href="http://cdn.jsdelivr.net/zurb/foundation-apps-1.1.0.css">
          <link rel="stylesheet" href="http://cdn.jsdelivr.net/zurb/foundation-apps-1.1.0.min.css">
          <link href="css/toaster.css" rel="stylesheet">

          <!-- Foundation for Apps -->
            <script src="http://cdn.jsdelivr.net/zurb/foundation-apps-1.1.0.js"></script>
            <script src="http://cdn.jsdelivr.net/zurb/foundation-apps-1.1.0.min.js"></script>
            <script src="http://cdn.jsdelivr.net/zurb/foundation-apps-templates-1.1.0.js"></script>
            <script src="http://cdn.jsdelivr.net/zurb/foundation-apps-templates-1.1.0.min.js"></script>


      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]><link href= "css/bootstrap-theme.css"rel= "stylesheet" >

<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
        </head>

  <body ng-cloak="" class="grid-frame vertical">
    <div class="dark shrink title-bar" role="navigation">
      <div class="center title">APO - Epsilon</div>
        <span class="left"><a zf-open="menu">Menu</a></span>
        <span class="right"><a zf-open="profile">Profile</a></span>
    </div>

    <div class="grid-content shrink collapse">
      <ul class="primary icon condense menu-bar">
        <li><a href="#"><strong>Home</strong></a></li>
        <li><a href="#"><strong>About</strong></a></li>
        <li><a href="#"><strong>Members</strong></a></li>
      </ul>
    </div>




    <div class="grid-content medium-12" style="margin-top:20px;">

    <div data-ng-view="" id="ng-view" class="slide-animation"></div>

    </div>

<!--       <zf-panel id="menu" position="left" zf-swipe-close="left" zf-esc-close>
      <a href="#" zf-close><img zf-iconic="" icon="circle-x" size="small">&times;</a>
      <ul class="menu-bar vertical">
        <li>
          <a href="#">
            <img src="http://placehold.it/50x50">
            <span class="block-list-label">Amazing Project  &#x2730;</span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="http://placehold.it/50x50">
            <span class="block-list-label">Amazing Project  &#x2730;</span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="http://placehold.it/50x50">
            <span class="block-list-label">Amazing Project  &#x2730;</span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="http://placehold.it/50x50">
            <span class="block-list-label">Update Info  &#x2730;</span>
          </a>
        </li>
      </ul>
    </zf-panel>

    <zf-panel id="profile" position="right" zf-swipe-close="right" zf-esc-close>
      <div class="grid-content small-12">
        <a href="#" zf-close><img zf-iconic="" icon="circle-x" size="small">&times;</a>
        <section class="block-list">
          <header>Activity</header>
          <ul>
            <li class="with-chevron">
              <a href="#">
                <img src="http://placehold.it/50x50">
                <span class="block-list-label">Attendance</span>
              </a>
            </li>
            <li class="with-chevron">
              <a href="#">
                <img src="http://placehold.it/50x50">
                <span class="block-list-label">Service Hours</span>
              </a>
            </li>
            <li class="with-chevron">
              <a href="#">
                <img src="http://placehold.it/50x50">
                <span class="block-list-label">Jarvis moved a file</span>
              </a>
            </li>
            <li class="with-chevron">
              <a href="#">
                <img src="http://placehold.it/50x50">
                <span class="block-list-label">Jarvis moved a file</span>
              </a>
            </li>
            <li class="with-chevron">
              <a href="#">
                <img src="http://placehold.it/50x50">
                <span class="block-list-label">Update Information</span>
              </a>
            </li>
          </ul>
        </section>
        </div>
    </zf-panel> -->
    </body>
  <toaster-container toaster-options="{
  'time-out': 2000}"></toaster-container>

  <!-- Libs -->
  <script src="js/angular.min.js"></script>
  <script src="js/angular-route.min.js"></script>
  <script src="js/angular-animate.min.js" ></script>
  <script src="js/toaster.js"></script>
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  <script src="app/authCtrl.js"></script>
</html>