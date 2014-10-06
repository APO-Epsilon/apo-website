<?php
require_once ('layout.php');
page_header();
?>
<div class="content">
Please enter the email address you used when you signed up, and we will send your password to you immediately.
If you don't receive an email, that means you either typed the email wrong, or registered with a different email address.  If you need help, Please contact the webmaster.

<form method="GET" action="login_sendpw.php" >
    <p>
    <label>E-mail</label><input type="text" size="30" name="email" id="email" value="" />
	<br />
    <input type="submit" value="Send"/>
    </p>
</form>

</div>

<?php
page_footer();
?>