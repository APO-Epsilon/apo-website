<?php
require_once('layout.php');
if(isset($_SESSION['sessionID']) && (('378' == $_SESSION['sessionID'])||('582' == $_SESSION['sessionID']))){
echo "<pre>
---------------------------------------------------------
[FORMAT]
YYYY-MM-DD  John Doe  <johndoe@example.com>

    * myfile.ext (myfunction): my changes made
    additional changes

    * myfile.ext (unrelated_change): my changes made
    to myfile.ext but completely unrelated to the above

    * anotherfile.ext (somefunction): more changes

[/FORMAT]
---------------------------------------------------------

    * denotes a change

    ** denotes a suggestion

---------------------------------------------------------

2012-11-06 Logan McCamon <logan@mccamon.org>

	* officers_committee_times.php : Page updated to display
	any information that has been submitted by committee
	members, even just a location, for example. In addition,
	the next scheduled committee time will be displayed.

2012-11-07 Logan McCamon <logan@mccamon.org>
	
	** publish_news.php : Make it easier to send message to 
	exec, add the ability to select multiple groups. Also, 
	Extend this ability to create_message.php for all exec
	board members.

	* publish_news.php : Page created. The webmaster can 
	publish news for members based on their status. Presently,
	the text is not checked for any symbols, ie. ', which must
	be converted to \' to avoid an error.

	* create_message.php : Page created. Working on adapting 
	the publish_news.php page for use by any exec member. 
	Details unspecified.

	* index.php : A script was added to display a message if 
	you have not taken and passed your risk management quiz.

2012-11-08 Logan McCamon <logan@mccamon.org>
	
	* new_service_hours.php : Reformated the service hours table
	and then modified the current service_hours.php file in 
	order to work with the changes. The changes did not go
	into effect. The test table was new_hours_table and the 
	change should go into effect at the end of the Fall semester
	after the Fall 2012 table has been backed-up.

	* check_hours.php : you can now check your hours on the
	mobile version of the website.
</pre>";}?>