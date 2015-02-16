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
        <div class="large-6 medium-9 small-12 columns">
           future service sign up!
           <div class="row">
<div class="row">
<table class="large-5 medium-6 small-12 column">
<tr>
<td>
<div class="large-8 medium-8 small-12 column">
<h2>Log Hours</h2>
<form action="service_hours.php" class="form" id="new_volunteer_time" method="post">
<p>
<label for="month">Date</label>
<select name="month">
<?php echo <<<END
<option value="$month_no">$month_name</option>
END; ?>
<option value="01">Jan</option>
<option value="02">Feb</option>
<option value="03">Mar</option>
<option value="04">Apr</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">Aug</option>
<option value="09">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>
<select name="day">
<?php echo <<<END
<option>$day_of_month</option>
END; ?>
    </div>
    <div id="footer"><?php include 'footer.php';?></div>
</body>
</html>
