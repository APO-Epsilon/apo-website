<?php
require_once ('session.php');
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
        <div class="large-10 medium-9 small-12 column large-centered medium-centered">
            <?php require_once('editable_page.php'); ?>
        </div>
    </div>
    <div id="footer"></div>
</body>
</html>
