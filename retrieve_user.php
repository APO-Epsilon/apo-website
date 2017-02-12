<?php
function select($operand, $condition, $value)
{
	include('mysql_access.php');
	$query = "SELECT $operand FROM contact_information WHERE $condition = '$value'";
	$results=$db->query($query);
	$final=mysqli_fetch_array($results);
	
	$results->free();
	
	return $final[$operand];
}

function email_to_id ($email) 
{	
  $operand = 'id';
  $condition = 'email';  
  
  $id = select($operand, $condition, $email);
  
  return $id;  
}

function id_to_email ($id)
{
  $operand = 'email';
  $condition = 'id';
  
  $email = select($operand, $condition, $id);
  
  return $email; 	
}

function id_to_position ($id)
{
	$operand = 'position';
	$condition = 'id';
	
	$position = select($operand, $condition, $id);
	
	return $position;
}
?>