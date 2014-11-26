<?php
require_once ('layout.php');

page_header();
?>

<div class="content">
<h1>APO Events Calendar</h1>
<p>The calendar is run with Google Calendars.  You must have this calendar shared with you in order to add events to it.  Please contact the webmaster for access if you need it.</p>

<h2>Updating the Calendar</h2>
<p>To make an update, log into your <a href='http://gmail.truman.edu/'>Gmail Truview Email account</a>.  When logged in, in the top left corner are several options, choose Calendars.</p>

<p align="center">
<img src="http://apo.truman.edu/layout_files/Calendar1.png" />
</p>

<p>
From there, you can navigate around the calendar to the needed date.  From there, you can simply click and drag to select the time slot overwhich the event occurs.  This will then allow for a dialog box to show up and you can input details.  If it is not applicable to to have a time slot, it is possible to initiate an all day event.  Make sure you chose "APO Calendar" as the calendar to post to and not the personal one which Google has created for you.
</p>
<?php
echo "</div>";
page_footer();
?>