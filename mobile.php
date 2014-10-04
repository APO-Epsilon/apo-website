<?php
	if(!session_start())
	{
		die("session start failed");
	}
	else
	{
		$session = $_SESSION;
		$arr = $session;
		
		foreach ($arr as $key => $value) 
		{
   			if($key == 'sessionID')
   			{
    			$sessionID = $value;
    		}
    		if($key == 'sessionFirstname')
    		{
    			$sessionFirstname = $value;
    		}
   			if($key == 'sessionLastname')
   			{
    			$sessionLastname = $value;
    		}
    		if($key == 'sessionexec')
    		{
    			$sessionexec = $value;
    		}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="user-scalable=no, width=device-width"/>
    <link rel="stylesheet" type="text/css" href="/includes/css/iphone.css" media="screen"/>
</head>
<body>

<?php require_once('mysql_access.php'); 

?>
    <div>
      <div class="button" onclick="window.location = 'http://apo.truman.edu/mobile.php';">Home</div>
      <h1>Alpha Phi Omega</h1>
      
      <?php 
      echo("<h2>Hello ".$sessionFirstname." ".$sessionLastname."</h2>"); 
      ?>
      <ul>
        <li class="arrow">Home<span class="right"></span></li>
        <!--<li class= "first-child" onclick="window.location = 'http://apo.truman.edu/mobile/service_hours.php';">Service Hours</li>-->
        <li class="arrow" onclick="window.location = 'http://apo.truman.edu/mobile/check_hours.php';">Check Hours</li>
        <li class="arrow" onclick="window.location = 'http://apo.truman.edu/mobile/members_list.php';">Members Contact Information</li>
        <li class="arrow" onclick="window.location = 'http://apo.truman.edu/mobile/attendance.php';">Attendance</li>
    	<?php if(!isset($sessionID)){?>
        <li class="arrow" onclick="window.location = 'http://apo.truman.edu/mobile/login.php';">Login</li>
        <?php }else{ ?>
        <li class="arrow" onclick="window.location = 'http://apo.truman.edu/mobile/logout.php';">Logout</li>
        <?php } ?>
      </ul>
    </div>
   	<a href="http://apo.truman.edu/index.php?browser=yes">in-browser</a>
</div>
  </body>
</html>