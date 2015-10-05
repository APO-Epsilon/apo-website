<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head> <script language="javascript" type="text/javascript">alert("Welcome My Minions")</script></head><font face="German"><span style="font-size: 35t; text-decoration: none"></span></a></font>
<script language="javascript" type="text/javascript">alert("Welcome My Minions")</script></head><font face="German"><span style="font-size: 35t; text-decoration: none"></span></a></font>
<script language="javascript" type="text/javascript">alert("Welcome My Minions")</script></head><font face="German"><span style="font-size: 35t; text-decoration: none"></span></a></font>
<script language="javascript" type="text/javascript">alert("Welcome My Minions")</script></head><font face="German"><span style="font-size: 35t; text-decoration: none"></span></a></font>
<script language="javascript" type="text/javascript">alert("Welcome My Minions")</script></head><font face="German"><span style="font-size: 35t; text-decoration: none"></span></a></font>
    <?php require 'head.php';?>
</head>
<body class="slide" data-type="background" data-speed="5">
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>
    <div class="row">
        <p><b>
        He is the Nick, but she is the Zoe
        </p></br>
<script>
// Set the number of snowflakes (more than 30 - 40 not recommended)
var snowmax=40

// Set the colors for the snow. Add as many colors as you like
var snowcolor=new Array("Red")
var snowcolor=new Array("Blue")
var snowcolor=new Array("Purple")
var snowcolor=new Array("Green")
var snowcolor=new Array("Yellow")
var snowcolor=new Array("Light Blue")
var snowcolor=new Array("Grey")

// Set the fonts, that create the snowflakes. Add as many fonts as you like
var snowtype=new Array("Arial Black","Arial Narrow","Times","Comic Sans MS")

// Set the letter that creates your snowflake (recommended:*)
var snowletter="Hello There ;)"

// Set the speed of sinking (recommended values range from 0.3 to 2)
var sinkspeed=0.6

// Set the maximal-size of your snowflaxes
var snowmaxsize=36

// Set the minimal-size of your snowflaxes
var snowminsize=8

// Set the snowing-zone
// Set 1 for all-over-snowing, set 2 for left-side-snowing 
// Set 3 for center-snowing, set 4 for right-side-snowing
var snowingzone=3

// Do not edit below this line
var snow=new Array()
var marginbottom
var marginright
var timer
var i_snow=0
var x_mv=new Array();
var crds=new Array();
var lftrght=new Array();
var browserinfos=navigator.userAgent 
var ie5=document.all&&document.getElementById&&!browserinfos.match(/Opera/)
var ns6=document.getElementById&&!document.all
var opera=browserinfos.match(/Opera/)  
var browserok=ie5||ns6||opera

function randommaker(range) {		
	rand=Math.floor(range*Math.random())
    return rand
}

function initsnow() {
	if (ie5 || opera) {
		marginbottom = document.body.clientHeight
		marginright = document.body.clientWidth
	}
	else if (ns6) {
		marginbottom = window.innerHeight
		marginright = window.innerWidth
	}
	var snowsizerange=snowmaxsize-snowminsize
	for (i=0;i<=snowmax;i++) {
		crds[i] = 0;                      
    	lftrght[i] = Math.random()*15;         
    	x_mv[i] = 0.03 + Math.random()/10;
		snow[i]=document.getElementById("s"+i)
		snow[i].style.fontFamily=snowtype[randommaker(snowtype.length)]
		snow[i].size=randommaker(snowsizerange)+snowminsize
		snow[i].style.fontSize=snow[i].size
		snow[i].style.color=snowcolor[randommaker(snowcolor.length)]
		snow[i].sink=sinkspeed*snow[i].size/5
		if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
		if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
		if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
		if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
		snow[i].posy=randommaker(2*marginbottom-marginbottom-2*snow[i].size)
		snow[i].style.left=snow[i].posx
		snow[i].style.top=snow[i].posy
	}
	movesnow()
}

function movesnow() {
	for (i=0;i<=snowmax;i++) {
		crds[i] += x_mv[i];
		snow[i].posy+=snow[i].sink
		snow[i].style.left=snow[i].posx+lftrght[i]*Math.sin(crds[i]);
		snow[i].style.top=snow[i].posy
		
		if (snow[i].posy>=marginbottom-2*snow[i].size || parseInt(snow[i].style.left)>(marginright-3*lftrght[i])){
			if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
			if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
			if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
			if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
			snow[i].posy=0
		}
	}
	var timer=setTimeout("movesnow()",50)
}

for (i=0;i<=snowmax;i++) {
	document.write("<span id='s"+i+"' style='position:absolute;top:-"+snowmaxsize+"'>"+snowletter+"</span>")
}
if (browserok) {
	window.onload=initsnow
}
</script>
        <img src= 'https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-xpf1/v/t35.0-12/11028481_672848639491002_1334602732_o.jpg?oh=ebf1554a938f6c53ad7da4c9b792d819&oe=54F4DB1C&__gda__=1425339084_c56f7fdd8403730b83c895b1fe693f59'> </br>
    </div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
