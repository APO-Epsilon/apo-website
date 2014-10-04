<?php
session_start();

// Yeah, these are kind of important.  A lot of random pages use them.
// So don't mess with them.  Make sure as you update the semesters you keep them
// the same,  that is don't switch previous_semester to "Fall10" if it was "Fall 2010"
$previous_semester = 'Spring 2014';
$current_semester = 'Fall 2014';
$next_semester = 'Spring 2015';
function page_header() {

    // Evil code to force memembers to update their information each new semester.
    // Seriously, evil.  You cannot do anything until you update.
    // -- Stephen Quinn
  global $current_semester;
  if (isset($_SESSION['active_sem'])) {
    if ($_SESSION['active_sem'] != $current_semester) {
      if (($_SERVER["REQUEST_URI"] != "/testing/updateinfo.php?forced=true") AND ($_SERVER["REQUEST_URI"] != "/testing/updateinfo.php")) {

          header( 'Location: /testing/updateinfo.php' ) ;

      }
    }
  }
}
function exec_links(){

 echo "<div class='entry'><a href='quizdate.php'>Risk Management Quiz Completion date.</a><br/><a href='pledgesummary.php'>Pledge Service Summary.</a><br/><a href='summary.php'>Chapter Service Summary.</a><br/><a href='execmail.php'>Exec e-mail list</a><br/><a href='exec_file_uploader.php'>Exec website file uploader</a><br/><a href='verifyhoursspring07.php'>Check Spring 2007 Service Hours</a><br/><a href='verifyhoursspring08.php'>Check Spring 2008 Service Hours</a><br/><a href='verifyhoursfall08.php'>Check Fall 2008 Service Hours</a></div>";

}
?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28249243-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>