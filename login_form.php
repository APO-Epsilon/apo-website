<div class="small-6 small-centered columns">
    <h1>Member Login</h1><br><br>
</div>
<div id="messagearea"></div>
<form id="loginform" name="loginform" method="post" action="login_process.php">
    <div class="large-6 medium-6 small-12 large-centered medium-centered columns">
        <label for="username">Username: </label>
        <input type="text" name="username" required autofocus/>
    </div><br>
    <div class="large-6 medium-6 small-12 large-centered medium-centered columns">
        <label for="password">Password: </label>
        <input type="password" name="password" required/>
    </div><br>
    <div class="large-6 medium-6 small-12 large-centered medium-centered columns">
        <input type="submit" class="expand button" value="Login"/>
        <input type="hidden" name="logstate" value="login"/>
    </div>
</form>
<div class="large-3 medium-3 small-6 large-offset-3 medium-offset-3 columns">
    <a href="register.php" class="button expand">Register</a>
</div>
<div class="large-3 medium-3 small-6 end columns">
    <a href="login_forgotpw.php" class="button expand">Forgot Password?</a>
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
