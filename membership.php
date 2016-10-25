<?php
require_once ('session.php');
require_once ('mysql_access.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->
<div class="row">

<?php
$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');

function show_active() {
      $user_id = $_SESSION['sessionID'];
      include('mysql_access.php');
      $response=$db->query("SELECT position FROM contact_information WHERE id = $user_id");
      $result=mysqli_fetch_array($response);
	  if (true) {
        echo '<h1>Membership</h1><br>';
		$page = null;
		//sets event info section from selection
		if(isset($_POST['page'])){
			$page = $_POST['page'];
		}
		?>
		<form name="myform" action="" method="post">
			<p> Choose a group: </p>
			<select name="page" onchange="this.form.submit()">
				<option value="All" selected>--</option>
				<option value="All (sorted)">All (by status)</option>
				<option value="All (unsorted)">All (alphabetical)</option>
				<option value="Active">Active</option>
				<option value="Pledge">Pledge</option>
				<option value="Associate">Associate</option>
				<option value="Senior">Senior</option>
				<option value="Inactive">Inactive</option>
				<option value="Alumni">Alumni</option>
				<option value="Exec">Exec</option>
			</select>
		</form>
		<?php
		display($page);
      }
      else{
        echo '<h2>You cannot see this page.</h2>';
      }
}

?>

<?php
function display($group) {
	if($group == 'All (sorted)') 
	{
		echo '<h2>Active Members</h2>';
        display_active_members();
		echo '<h2>Pledge Members</h2>';
		display_pledge_members();
		echo '<h2>Associate Members</h2>';
		display_associate_members();
		echo '<h2>Senior Members</h2>';
		display_senior_members();
		echo '<h2>Inactive Members</h2>';
		display_inactive_members();
		echo '<h2>Alumni Members</h2>';
		display_alumni_members();
	}
	else if ($group == 'All (unsorted)')
	{
		echo '<h2>All Members</h2>';
		display_all_members();
	}
	else if ($group == 'Active')
	{
		echo '<h2>Active Members</h2>';
        display_active_members();		
	}
	else if ($group == 'Pledge')
	{
		echo '<h2>Pledge Members</h2>';
		display_pledge_members();		
	}
	else if ($group == 'Associate')
	{
		echo '<h2>Associate Members</h2>';
		display_associate_members();		
	}
	else if ($group == 'Senior')
	{
		echo '<h2>Senior Members</h2>';
		display_senior_members();		
	}
	else if ($group == 'Inactive')
	{
		echo '<h2>Inactive Members</h2>';
		display_inactive_members();		
	}
	else if ($group == 'Alumni')
	{
		echo '<h2>Alumni Members</h2>';
		display_alumni_members();
	}
	else if($group == 'Exec') 
	{
		echo '<h2>Exec Members</h2>';
		display_exec_members();
	}
}
function display_active_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
    while($result=mysqli_fetch_array($response)){
      if ( ($result['status'] == 'Active') || ($result['status'] == 'Elected') || ($result['status'] == 'Appointed') ) {
		$count++;  
        echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
      }
    }
    echo '</table>';
}
function display_all_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
    while($result=mysqli_fetch_array($response)){
		$count++;  
		echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
    }
    echo '</table>';
}
function display_alumni_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE status = 'Alumni' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
	while($result=mysqli_fetch_array($response)){
		$count++;  
        echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
    }
    echo '</table>';
}
function display_associate_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE status = 'Associate' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
    while($result=mysqli_fetch_array($response)){
		$count++;  
        echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
    }
    echo '</table>';
}
function display_exec_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE status = 'Elected' OR status = 'Appointed' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
    while($result=mysqli_fetch_array($response)){
		$count++;  
        echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
    }
    echo '</table>';
}
function display_inactive_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE status = 'inactive' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
    while($result=mysqli_fetch_array($response)){
		$count++;  
        echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
    }
    echo '</table>';
}
function display_pledge_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE status = 'Pledge' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
    while($result=mysqli_fetch_array($response)){
		$count++;  
        echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
    }
    echo '</table>';
}
function display_senior_members() {
    $count = 0;
    include('mysql_access.php');
    $response=$db->query("SELECT * FROM contact_information WHERE status = 'Senior' ORDER BY lastname");
    echo '<table>';
    echo '<tr><td>#</td><td>Last Name</td><td>First Name</td><td>Status</td><td>Email</td><td>Position</td></tr>';
    while($result=mysqli_fetch_array($response)){
		$count++;  
        echo '<tr><td>' . $count . '</td><td>' . $result['lastname'] . '</td><td>' . $result['firstname'] . '</td><td>' . $result['status'] . '</td><td>' . $result['email']. '</td><td>' . $result['position'] . '</td></tr>';
    }
    echo '</table>';
}
 
?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
