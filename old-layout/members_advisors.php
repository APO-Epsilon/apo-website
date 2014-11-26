<?php
require_once ('layout.php');


page_header();
echo "<div class='content'>";
if (!isset($_SESSION['sessionID'])) {
		echo('<div class="content">');
		echo '<strong>You need to login before you can see this section.</strong>'; 
		page_footer();
		echo('</div>');
	} 

	else {

	echo<<<END





	  <div class="entry">

<h1>Advisorsory Committee</h1>
<div> 
<p style="text-indent: 3em;">Advisors have a vital role of any healthy Alpha Phi Omega chapter. They offer objectivity, historical perspective, and resources to help chapters reach their goals. The most successful and thriving chapters of Alpha Phi Omega are those that seek to maintain a strong relationship with their advisors. </p>
 
<p style="text-indent: 3em;">Because advisors are not active members, they may carry a different and helpful perspective on a variety of issues that chapters face. Advisors often are capable of providing advice or opinions as an impartial party. They can mediate conflicts between groups or individuals within the chapter. Advisors can just provide counsel for any member who needs a listening ear. Advisors also can provide feedback on possible service opportunities. They can help serve as a link between the Chapter and the University campus, community and/or local scouting organizations. Advisors can be a sounding board for ideas for continuing to bring about positive growth for Alpha Phi Omega on this campus. Advisors also count ballots during chapter elections, award nominations, and are a vital resource for any matters pertaining to risk management.</p>
 
<p style="text-indent: 3em;">All Alpha Phi Omega Chapters are required to have, at minimum, two advisors from the faculty/administration/staff of the University, one advisor representing Scouting/or other youth service, and one from the community. Chapters may have more advisors if they so desire.</p>
 
<p style="text-indent: 3em;">Faculty/administration/staff advisors are here to serve as a link between Epsilon and Truman State University, and should be in a position to help navigate some of the University policies. The Scouting/youth services advisor is to help the chapter provide service to youth across the nation (and in the Kirksville/Adair County area), an obligation we accept in the Fraternity oath. While that advisor may have affiliation with the Boy Scouts of America, it is not mandatory. The Community advisor(s) is/are there to help the chapter access the local community beyond the campus, or could assist the chapter with accessing the broader resources of Alpha Phi Omega at the national, regional and sectional level.</p>
</div>
<b>Tim Barcus</b>
<ul>
	<li>Faculty / Staff Advisor</li>
	<li>Email: tbarcus@truman.edu</li>
	<li>Office: KB 209</li>
	<li>Phone: (660) 785-4224</li>
</ul>

<b>Kara Jo Humphrey</b>
<ul>
	<li>Faculty/Staff Advisor</li>
	<li>Email: karah@truman.edu</li>
	<li>Office: RTM 1010</li>
	<li>Phone: (660) 665-0878</li>
</ul>

<b>Ken Carter</b>
<ul>
	<li>Scouting Advisor</li>
	<li>Email: kcarter@truman.edu</li>
	<li>Office: MG 3146</li>
	<li>Phone: (660) 785-4628</li>
</ul>

<b>Jim Roach</b>
<ul>
	<li> Community Advisor</li>
	<li> jwroach49@yahoo.com</li>
	<li> (314) 330-6822</li>

</ul>

<b>Marlene Talbert</b>
<ul>
	<li>Community Advisor</li>
	<li>Email: druandmarlene@gmail.com</li>
	<li>Phone: (660) 956-2716</li>
</ul>

<b>Linda "Mom" Caraway</b>
<ul>
	<li>Community Advisor</li>
	<li>Email: l.caraway@gmail.com</li>
	<li>Phone: (660) 341-7548</li>
</ul>
</div>
</div>

END;
page_footer();
}

echo "</div>";

?>