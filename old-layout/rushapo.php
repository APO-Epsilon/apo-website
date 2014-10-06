<?php
require_once ('layout.php');
require_once ('mysql_access.php');

page_header();

$searchquery = "SELECT `firstname`, `lastname`, `email` FROM apo.contact_information WHERE `position` = 'Rush Chairman' GROUP BY lastname, firstname ;";
$search = mysql_query($searchquery) or die("SEARCH FAILED");

if ($_SESSION['sessionexec'] == 17) {echo('<a href="//apo.truman.edu/rush_apo.php">edit this page</a>');}

echo<<<END
<div class="content">

<h1>Join APO</h1>
<p>If you are considering rushing APO, please utilize the information provided in this section to help you with your decision. You could also contact our current rush chairs. or you can sign up on our mailing list <a href="https://groups.google.com/forum/#!forum/apo_epsilon">here</a></p>

<h2>Rush Chairs</h2>
<p>The Rush Chairs are in charge of organizing Rush Week each semester and helping potential pledges discover what APO is all about.  This semester's chairs are:
<ul>
END;
while ($rname = mysql_fetch_array($search)) {
	extract($rname);
	print "<li><b>$rname[firstname] $rname[lastname]</b>";
	print " (<a href='mailto:$email'>$email</a>)</li>";
}
echo "</ul>
Don't be afraid to email one to ask some questions about joining APO.
";
?>
</p>


<p>Rush for Fall 2014 begins in September!</p>

<h2>Requirements for Rushees</h2>
<p>Each individual seeking to join APO must complete the following Rush events:<br/>
<ul>
<li>1 Informational meeting (Sept. 9, 10, or 11 at 6:30 or 7:30 in VH1412)</li>
<li>RA Dinner attendance</li>
<li>3 Fellowship events</li>
<li>3 Service events</li>
<li>Smoker attendance *</li>
</ul>
<i>* When you finish all previous requirements, you will be invited to Smoker</i>
</p>


<h2>RUSH FAQ</h2>

<p><b>What is Alpha Phi Omega?</b><br />
Alpha Phi Omega is a National Coeducational Service Fraternity-college students gathered together in an organization based on fraternalism and founded on the fellowship of principles derived from the Scout Oath and Law of the Boy Scouts of America.  Its purpose is to develop leadership, promote friendship, and provide service to humanity.</p>

<p><b>Who Can Join?</b><br />
Any student duly enrolled at Truman State University, who joins with the chapter's members in their service projects, accepts the principles of Scouting on which the Fraternity's ideals are based, and meets the standards of the Epsilon Chapter.

<p><b>Why Should You Join?</b><br />
College should be more than the acquisition of facts and figures; it should also broaden you experiences, expand and test you inherent abilities and sharpen you social skills.  Alpha Phi Omega, through its unique program of leadership, friendship, and service, can add this necessary but often lacking aspect of college life, and at the same time enable you to help others while helping yourself.</p>

<p>
<b>Can I join APO and still be involved in other activities?</b><br />
Yes!  Many of our members are involved with several organizations on campus.  As long as APO members complete requirements to remain in good standing each semester, they have flexibility in determining how much they do with APO and their other organizations.  We also offer different types of membership to meet the needs of our members.</p> 

<p><b>What kinds of things would I do in APO?</b><br />
The possibilities are endless.  There are always many different service projects going on in APO, whether it is playing cards with the residents at the Twin Pines nursing home, working with kids at the local YMCA, writing letters to pen pals at elementary schools, working at the local library, helping out with blood drives for the Red Cross, and so many more.  In addition to service events, brotherhood activities give APO members the chance to form friendships and have a great time.  Events range from the weekly brotherhood dinner to movie nights to the annual Formal dance.</p>

<p><b>What kinds of leadership opportunities are there in APO?</b><br />
Leadership is one of the cardinal principles of APO, and we strive to give our members numerous opportunities to hone and develop their leadership potential.  During the pledging process, pledges can assume various roles within the pledge class to plan service projects or other events.  The executive board for the chapter typically has fourteen elected positions and seven appointed positions, allowing for a typical board of 20-30 people each semester.  This large board gives many people to take an active role within the chapter, and there is a position to fit just about any interest or talent members may have.  In addition to these positions, members can be leaders by acting as a project leader or family head.</p>

<p><b>How large is the organization?</b><br />
APO is currently the largest organization on the Truman State University Campus.  Membership varies from semester to semester, but we typically have about 200 members.  A typical pledge class has about 40-50 people.</p>

<p><b>Is it hard to gain admission into APO?</b><br />
No. APO is not exclusive in its recruitment process, so anyone with the desire to serve is encouraged to join.  As long as you complete the rush requirements (usually three service events and three fellowship events), you will be invited to join the organization.</p>

</div>
<?php
page_footer();
?>