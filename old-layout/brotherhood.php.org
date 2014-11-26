<?php
require_once('layout.php');
require_once('mysql_access.php');
page_header();

global $current_semester;

//0 => not under development, 1 => under development.
$dev = 1;

$user_id = $_SESSION['sessionID'];
echo("<div class='content'>");

function display_form(){
	/*display create event form
	*we need to ask for... 
	*$name -- name of the event (show all previously
	*recorded for broho)
	*$points -- point worth of the event
	*$date -- date (Y-m-d) of the event
	*$who -- the who of the event, one possibility 
	*for this is to use javascript to hide all by 
	*default and only show those who have been clicked,
	*ie. if it is a pledge event then only display
	*their names on the form page.
	*send the form on submit to the function create_event()
	*/


}

function process_form(){
	/*create a new event, 
	*set a value, draw the default in if the event had been
	*recorded previously.
	*take the form & process the name, & date for 
	*all of the users that have been recorded as attending
	*the event.
	*/
}

//master if else statement goes here
if(isset($_POST['navigation']) && ($_POST['navigation'] == 'display_form')){
	display_form();
}elseif(1 == 1){
	echo"";
}

//display initial form
echo 
<<<END
	<form method="post" action="$_SERVER[PHP_SELF]">
		<fieldset>
			<legend>Initial Form:</legend>
				<select name="where">
					<option value="log"/>
					<option value="edit"/>
				</select>
				<inpyt type="hidden" name="navigation" value="display_form"/>
				<input type="submit"/>
		</fieldset>
	</form>

END;
page_footer();
?>