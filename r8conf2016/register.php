<?php
require_once ('session.php');
require_once ('../mysql_access.php');
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
if (!isset($_SESSION['sessionConfID'])) {
?>
		<div class="small-12 columns">
			<h2>Register for the Conference</h2>
		</div>
	</div>
	<form action="register_process2.php" method="POST" autocomplete="on">
		<div class="row">
			<div class="medium-9 small-12 small-centered columns">
				<div class="row">
					<fieldset>
						<legend>Personal Information</legend>	
						<div class="medium-6 small-12 columns">
							<label for="fname">First Name</label>
							<input type="text" name="fname" placeholder="Jim" required autocomplete="fname" autofocus/>
						</div>
						<div class="medium-6 small-12 columns">
							<label for="lname">Last Name</label>
							<input type="text" name="lname" placeholder="Roach" required autocomplete="lname" />
						</div>
						<div class="medium-6 small-12 columns">
							<label for="email">Email</label>
							<input type="email" name="email" placeholder="BrotherRoach@LFS.com" required autocomplete="email" />
						</div>
						<div class="medium-6 small-12 columns">
							<label for="tel1">Phone Number</label>
							<strong>(</strong>
							<input type="tel" name="tel1" placeholder="555" required minlength="3" maxlength="3" style="width: 25%; display: inline; text-align: center;" />
							<strong>)</strong>
							<input type="tel" name="tel2" placeholder="867" required minlength="3" maxlength="3" style="width: 25%; display: inline; text-align: center;" />
							<strong>-</strong>
							<input type="tel" name="tel3" placeholder="5309" required minlength="4" maxlength="4" style="width: 30%; display: inline; text-align: center;" />
						</div>
						<div class="medium-6 small-12 columns">
							<label for="password1">Password</label>
							<input type="password" name="password1" id="password1" minlength="8" maxlength="20" placeholder="At least 8 alphanumeric characters" required />
							<small class="error" id="password1error" style="display: none;">Invalid Password</small>
						</div>
						<div class="medium-6 small-12 columns">
							<label for="password2">Confirm Password</label>
							<input type="password" name="password2" id="password2" minlength="8" maxlength="20" placeholder="At least 1 letter, 1 number" required />
							<small class="error" id="password2error" style="display: none;">Password Mismatch</small>
						</div>
					</fieldset>
					<fieldset>
						<legend>Conference Information</legend>
						<div class="small-6 columns">
							<label for="status">Registration</label>
							<select id="status" required style="width: 80%;">
								<option></option>
								<option value="Active">Active</option>
								<option value="Alumni">Alumni</option>
							</select>
						</div>
						<div class="small-6 columns">
							<label for="housing">Brother Housing</label>
							<input type="radio" name="housing" value="Yes" id="hyes" required>Yes
							<div style="display: block;"><input type="radio" name="housing" value="No" id="hno">No</div>
						</div>
						<div class="small-6 columns">
							<label for="TShirtSize">T-shirt size</label>
							<select id="ShirtSize" required style="width: 30%;">
								<option></option>
								<option value="S">S</option>
								<option value="M">M</option>
								<option value="L">L</option>
								<option value="XL">XL</option>
								<option value="2XL">2XL</option>
								<option value="3XL">3XL</option>
							</select>
						</div>
						<div class="small-6 columns">
							<label for="chapter1">Chapter</label>
							<select id="chapter1" required style="width: 30%;">
								<option></option>
								<option value="Alpha">Alpha</option>
								<option value="Beta">Beta</option>
								<option value="Gamma">Gamma</option>
								<option value="Delta">Delta</option>
								<option value="Epsilon">Epsilon</option>
								<option value="Zeta">Zeta</option>
								<option value="Eta">Eta</option>
								<option value="Theta">Theta</option>
								<option value="Iota">Iota</option>
								<option value="Kappa">Kappa</option>
								<option value="Lambda">Lambda</option>
								<option value="Mu">Mu</option>
								<option value="Nu">Nu</option>
								<option value="Xi">Xi</option>
								<option value="Omicron">Omicron</option>
								<option value="Pi">Pi</option>
								<option value="Rho">Rho</option>
								<option value="Sigma">Sigma</option>
								<option value="Tau">Tau</option>
								<option value="Upsilon">Upsilon</option>
								<option value="Phi">Phi</option>
								<option value="Chi">Chi</option>
								<option value="Psi">Psi</option>
								<option value="Omega">Omega</option>
							</select>
							<select id="chapter2" style="width: 30%;">
								<option></option>
								<option value="Alpha">Alpha</option>
								<option value="Beta">Beta</option>
								<option value="Gamma">Gamma</option>
								<option value="Delta">Delta</option>
								<option value="Epsilon">Epsilon</option>
								<option value="Zeta">Zeta</option>
								<option value="Eta">Eta</option>
								<option value="Theta">Theta</option>
								<option value="Iota">Iota</option>
								<option value="Kappa">Kappa</option>
								<option value="Lambda">Lambda</option>
								<option value="Mu">Mu</option>
								<option value="Nu">Nu</option>
								<option value="Xi">Xi</option>
								<option value="Omicron">Omicron</option>
								<option value="Pi">Pi</option>
								<option value="Rho">Rho</option>
								<option value="Sigma">Sigma</option>
								<option value="Tau">Tau</option>
								<option value="Upsilon">Upsilon</option>
								<option value="Phi">Phi</option>
								<option value="Chi">Chi</option>
								<option value="Psi">Psi</option>
								<option value="Omega">Omega</option>
							</select>
							<select id="chapter3" style="width: 30%;">
								<option></option>
								<option value="Alpha">Alpha</option>
								<option value="Beta">Beta</option>
								<option value="Gamma">Gamma</option>
								<option value="Delta">Delta</option>
								<option value="Epsilon">Epsilon</option>
								<option value="Zeta">Zeta</option>
								<option value="Eta">Eta</option>
								<option value="Theta">Theta</option>
								<option value="Iota">Iota</option>
								<option value="Kappa">Kappa</option>
								<option value="Lambda">Lambda</option>
								<option value="Mu">Mu</option>
								<option value="Nu">Nu</option>
								<option value="Xi">Xi</option>
								<option value="Omicron">Omicron</option>
								<option value="Pi">Pi</option>
								<option value="Rho">Rho</option>
								<option value="Sigma">Sigma</option>
								<option value="Tau">Tau</option>
								<option value="Upsilon">Upsilon</option>
								<option value="Phi">Phi</option>
								<option value="Chi">Chi</option>
								<option value="Psi">Psi</option>
								<option value="Omega">Omega</option>
							</select>
						</div>
						<div class="small-6 columns">
							<label for="payment">Payment Method</label>
							<select id="payment" required>
								<option></option>
								<option value="personal">Personal Check</option>
								<option value="chapter">Chapter Check</option>
								<option value="online">Online Payment</option>
							</select>
							<a href="http://www.google.com" id="paybutton" target="_blank" class="button tiny" style="display: none;">Pay Here</a>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="large-6 medium-6 small-12 large-offset-3 medium-offset-3 columns">
			 	<input type="hidden" id="stage" value="process" />
			 	<input type="submit" class="button expand" value="Register" />
	 		</div>
	 	</div>
	</form>
	<script>
		//jQuery is currently included on every page by the site. If this changes, include the src to it above this script
		$("#payment").change(function() {
			var value = $(this).val();
			if(value == "online") {
				$("#paybutton").fadeIn();
			} else {
				$("#paybutton").fadeOut();
			}
		});

		$("#password1").change(function() {
			ValidatePassword();
		});

		$("#password2").change(function() {
			ConfirmPassword();
		});

		function ConfirmPassword() {
			var pw1 = $("#password1").val();
			var pw2 = $("#password2").val();
			if(pw1 == pw2) {
				$("#password2error").hide();
			} else {
				$("#password2error").show();
			}
		}

		function ValidatePassword() {
			var input = $("#password1").val();
			var check = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/;
			if(input.match(check)) {
				$("#password1error").hide();
			} else {
				$("#password1error").show();
			}
		}
	</script>
<?php
} else {
?>
		<div class="small-12 columns">
			<p>It appears that you're already registered for the conference. If you'd like to register another attendee, please click the "Logout" button below and then return to this page.</p>
		</div>
		<div class="small-12 columns">
			<a href="login.php" class="button expand">Logout</a>
		</div>
<?php
}
?>
	</div>
	<br>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
