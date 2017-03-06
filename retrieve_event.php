<?php
function select_event($operand, $condition, $value)
{
	include('mysql_access.php');
	$query = "SELECT $operand FROM events_listing WHERE $condition = '$value'";
	$results=$db->query($query);
	$final=mysqli_fetch_array($results);
	
	$results->free();
	
	return $final[$operand];
}

function id_to_name ($id) 
{	
  $operand = 'event_name';
  $condition = 'id';  
  
  $name = select_event($operand, $condition, $id);
  
  return $name;  
}

function signup ($uid,$eid)
{
	include('mysql_access.php');	
	$statement ="INSERT INTO events_signup (user_id,event_id) VALUES ($uid,$eid)";
	$result = $db->query($statement) or die("could not update");
}

function add_excuse ($uid,$eid,$excuse,$semester)
{
	include('mysql_access.php');
	$statement ="INSERT INTO excused (user_id,event_id,excuse,semester) VALUES ($uid,$eid,'$excuse','$semester')";
	$result = $db->query($statement) or die("could not update");	
}

function missed_meeting ($uid,$meeting,$excuse,$semester)
{
	include('mysql_access.php');
	$statement ="INSERT INTO meetings_missed (user_id,meeting,semester,excuse) VALUES ($uid,'$meeting','$semester','$excuse')";
	$result = $db->query($statement) or die("could not update");	
}

function did_user_attend ($uid,$eid)
{
	include('mysql_access.php');
	$query = "SELECT user_id FROM events_signup WHERE event_id = '$eid' AND user_id = '$uid'";
	$results=$db->query($query);
	$final=mysqli_fetch_array($results);
	
	$results->free();
	
	if ($final['user_id'] == $uid)
	{
		$present = true;
	}
	else
	{
		$present = false;
	}
	
	return $present;	
}

function is_user_excused ($uid,$eid)
{
	include('mysql_access.php');
	$query = "SELECT user_id FROM excused WHERE event_id = '$eid' AND user_id = '$uid'";
	$results=$db->query($query);
	$final=mysqli_fetch_array($results);
	
	$results->free();
	
	if ($final['user_id'] == $uid)
	{
		$present = true;
	}
	else
	{
		$present = false;
	}
	
	return $present;	
}

?>