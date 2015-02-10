<?php
require_once ('session.php');
require_once ('mysql_access.php');
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
		<div class="large-6 medium-6 small-12 columns">
			<form action="register_process.php" method="POST">
			<b>Personal</b><br>
				<label for="first_name">First Name</label>
				<input type="text" name="firstname"/>
			<br>
				<label for="last_name">Last Name</label>
				<input type="text" name="lastname" />
			<br>
				<label for="birthday">Birthday</label>
					<select name="bmonth" id="bmonth">
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select name="bday" id="bday">
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
						<option>21</option>
						<option>22</option>
						<option>23</option>
						<option>24</option>
						<option>25</option>
						<option>26</option>
						<option>27</option>
						<option>28</option>
						<option>29</option>
						<option>30</option>
						<option>31</option>
					</select>
					<input name="byear" type="text" size="8" maxlength="4"/>
				<br>

			<b>APO</b><br>
				<label for="pledgesem">Pledge Semester</label>
					<select name="pledgesem">
						<option value="Fall">Fall</option>
						<option value="Spring">Spring</option>
					</select>
					<select name="pledgeyear">
						<option value="2015">2015</option>
						<option value="2013">2013</option>
						<option value="2012">2012</option>
						<option value="2011">2011</option>
						<option value="2010">2010</option>
						<option value="2009">2009</option>
					</select>
				<br>
				<label for="famflower">Flower</label>
					<select name="famflower">
						<option value="Pink Carnation">Pink Carnation</option>
						<option value="Red Carnation">Red Carnation</option>
						<option value="Red Rose">Red Rose</option>
						<option value="White Carnation">White Carnation</option>
						<option value="White Rose">White Rose</option>
						<option value="Yellow Rose">Yellow Rose</option>
					</select>
				<br>
				<label for="status">Status</label>
					<select name="status">
						<option value="Active">Active</option>
						<option value="Associate">Associate</option>
						<option value="Pledge">Pledge</option>
						<option value="Alumni">Alumni</option>
						<option value="Early Alum">Early Alum</option>
						<option value="Advisor">Advisor</option>
						<option value="Inactive">Inactive</option>
					</select>
				<br>
				<label for="bigbro">Big Brothers</label>
					<input type="text" name="bigbro"/>
				<br>
				<label for="littlebro">Little Brothers</label>
					<input type="text" name="littlebro" value=""/>
		</div>
		<div class="large-6 medium-6 small-12 columns">
			<b>School</b><br>
				<label name="major">Major</label>
					<input type="text" name="major"/>
				<br>

				<label for="minor">Minor</label>
					<input type="text" name="minor"/>
				<br>

				<label for="gradmonth">Graduation Date</label>
					<select name="gradmonth">
						<option value="May">May</option>
						<option value="August">August</option>
						<option value="December">December</option>
					</select>
					<select name="gradyear">
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
					</select>
				<br>

				<label for="schoolyear">Year</label>
					<select name="schoolyear">
						<option>Freshman</option>
						<option>Sophomore</option>
						<option>Junior</option>
						<option>Senior</option>
						<option>Alumni</option>
						<option>Other</option>
					</select>
				<br>
				<br>

			<b>Contact</b><br>
				<label for="email">Email</label>
					<input type="text" name="email"/>
				<br>

				<label for="phone">Phone</label>
					<input type="text" name="phone"/>
				<br>

				<label for="local">Local Address</label>
					<input type="text" name="localaddress"/>
				<br>

				<label for="perm">Permanent Address</label>
					<input type="text" name="homeaddress"/>
				<br>

				<label for="perm"></label>
					<input type="text" name="citystatezip"/>
				<br>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<b>Login</b><br>
				<label for="username">Username*</label>
					<input type="text" name="username" />
			<br>

			<label for="password">Password</label>
				<input type="password" name="password" />
			<br>

			<label for="regpass">Registration PW</label>
				<input type="text" name="regpass" />

			 		<p align="center">
			 		<input type="hidden" name="stage" value="process" />
			 		<input type="submit" value="Register" />
			 		</p>
			</form>
		</div>
</div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
