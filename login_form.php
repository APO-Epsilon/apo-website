<table>
<div class="small-12 columns">
<h1>Member Login</h1>
<p>Please log in if you belong to Epsilon and have an account.  If you do not have an account, please contact the webmaster for the registration password and <a color="#FFFF00" href='register.php'>sign up</a>.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a>
</p>
<div id="messagearea"></div>
		<form id="loginform" name="loginform" method="post" action="login_process.php">
		<tr>
		<td width="40%">Username:</td><td width="60%"><input type="text" name="username"/></td>
		</tr>
		<tr>
		<td width="40%">Password:</td><td width="60%"><input id="password" type="password" name="password"/></td>
		</tr>
		<tr>
		<td><input type="submit" value="Login"/></td>
		</tr>
		<input type="hidden" name="logstate" value="login"/>
		<input type="hidden" name="referringpage" value="$_SERVER[PHP_SELF]"/>
</form>
</table>
</div>
<script>
<!-- This script requires jQuery. It is currently included on every page, but make sure to include it should that change -->
	$(document).ready(function() {
		//Stop the form submission and submit with AJAX
		$("#loginform").submit(function() {
			$.ajax({
				data: $(this).serialize(),
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				success: function(response) {
					//If login was unsuccessful
					if (response == "Failed") {
						$("#messagearea").html("<p style='color:red'>Authentication failed.  Please try again.</p>");
					} else if (response == "Success") {
						//If login was successful
						var currentPage = location.href.split("/").slice(-1);
						if (currentPage == "login.php") {
							//If logged in on the login page itself, send to index
							window.location.replace("/index.php");
						} else {
							//AJAX call to get new page after successful login
							$.ajax({
								url: currentPage,
								success: function(response) {
									//Filter the page down to the content contained in div with class="row" and replace the current page content
									var bodyhtml = $(response).filter('div.row');
									$('div.row').replaceWith(bodyhtml);
								}
							});
						}
					}
				},
				error: function(jqXHR, exception) {
					//If the AJAX call can't reach the login process
		            if (jqXHR.status === 0) {
		                $("#messagearea").html('<p>Unable to connect to the network</p>');
		            } else if (jqXHR.status == 404) {
		                $("#messagearea").html('<p>Requested page not found [404]</p>');
		            } else if (jqXHR.status == 500) {
		                $("#messagearea").html('<p>Internal Server Error [500]</p>');
		            } else if (exception === 'parsererror') {
		                $("#messagearea").html('<p>Requested JSON parse failed</p>');
		            } else if (exception === 'timeout') {
		                $("#messagearea").html('<p>Time out error</p>');
		            } else if (exception === 'abort') {
		                $("#messagearea").html('<p>Ajax request aborted</p>');
		            } else {
		                $("#messagearea").html('Uncaught Error.\n' + jqXHR.responseText);
		            }
		        }
			});
			return false;
		});
	});
</script>
