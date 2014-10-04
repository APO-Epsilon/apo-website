<?php
require_once('utility_functions.inc.php');

function print_form() { 
$db = newPDO();
$id = $_SESSION['sessionID'];
$sql = "SELECT * FROM Member WHERE id = $id LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->execute()
//grabs all the user's information to use as defaults
$user = $stmt->fetch();
//stores different forms of birthday info to use as defaults
$birthdayMonthNum = $user['birthday'].explode('-')[1];
$birthdayMonthName = date("F", mktime(0, 0, 0, intval($birthdayMonthName), 10));
$birthdayDay = $user['birthday'].explode('-')[2];
$birthdayYear = $user['birthday'].explode('-')[0];
echo <<<END
	<div class="content">
	
	
	<form method="POST"> 
<p> 
<b>Personal</b><br/> 
<label for="first_name">First Name</label> 
<input type="text" name="firstname" value = "{$user['firstname']}" maxlenght="20" required/> 
<br/> 
 
<label for="last_name">Last Name</label> 
<input type="text" name="lastname" value = "{$user['lastname']}" maxlength="20" required/> 
<br/> 
 
<label for="birthday">Birthday</label> <!--be sure to concatenate in YYYY-MM-DD format-->
<select name="bmonth" id="bmonth" required> 
	<option value=$birthdayMonthNum>{$birthdayMonthName}</option>
	<option value="01">January</option> 
	<option value="02">February</option> 
	<option value="03">March</option> 
	<option value="04">April</option> 
	<option value="05">May</option> 
	<option value="06">June</option> 
	<option value="07">July</option> 
	<option value="08">August</option> 
	<option value="09">September</option> 
	<option value="10">October</option> 
	<option value="11">November</option> 
	<option value="12">December</option> 
</select> 
<select name="bday" id="bday" required>
	<option value=$birthdayDay>$birthdayDay</option>
END;
for($i=1;$i<=31;$i++){
  if($i<10){
    $p = "0".$i;
  } else {
    $p = $i;
  }
  echo "<option value=$p>$i</option>"; 
};
echo <<<END
</select>
 
<select name="byear" id="byear" required>
	<option value = $birthdayYear>$birthdayYear</option>
END;
$year = date('Y');
for($i=-27; $i<=-16; $i++){
  echo "<option value=".($year+$i).">".($year+$i)."</option>";
};
echo <<<END
</select> 
<br/> 
 
<b>APO</b><br/> 
<label for="pledgesem">Pledge Semester</label> 
<select name="pledgesem" required> 	
	<option value="Spring">Spring</option> 
	<option value="Fall">Fall</option> 
</select> 

<select name="pledgeyear" required>
	<option value = "{$user['pledgeyear']}">$user['pledgeyear']</option>
END;

$year = date('Y');
for($i=-6; $i<=0; $i++){
  echo "<option value=".($year+$i).">".($year+$i)."</option>";
};

echo <<<END


</select> 
<br/> 

<input type="hidden" name="status" value="1">
<input type="hidden" name="flower" value="1">
 
<b>School</b><br/> 
<label name="major">Major</label> 
<select name="major[]" multiple>
END;

$db = newPDO();
$sql = "SELECT * FROM `MajorRoster` WHERE M_Id = $user['id']";
$stmt = $db->prepare($sql);
$stmt->execute();
//Need to figure out how the selection of majors occurs when a user has multiple majors
$sql = "SELECT * FROM `Major`";
$stmt = $db->prepare($sql);
$stmt->execute();
$majors = $stmt->fetchAll();


foreach($majors as $row){
	$id = $row['Major_Id'];
	$name = $row['Name'];
  echo "<option value=$id>$name</option>";
}
echo <<<END
</select> 
<br/> 

<label for="minor">Minor</label> 
<select name="minor[]" multiple <!--required-->>
END;
//Need to figure out how the selection of majors occurs when a user has multiple majors
$db = newPDO();
$sql = "SELECT * FROM `MajorRoster` WHERE M_Id = $user['id']";
$stmt = $db->prepare($sql);
$stmt->execute();

$sql = "SELECT * FROM `Minor`";
$stmt = $db->prepare($sql);
$stmt->execute();
$majors = $stmt->fetchAll();


foreach($majors as $row){
	$id = $row['Minor_Id'];
	$name = $row['Name'];
  echo "<option value=$id>$name</option>";
}

echo <<<END
</select>
<br/> 
 
<label for="gradsem">Graduation Date</label> 
<select name="gradsem" required> 
<option value="summer">Summer</option>
<option value="spring">Spring</option>
<option value="fall">Fall</option>
</select> 
<select name="gradyear" required>
	<option name = "{$user['gradyear']}">$user['gradyear']</option>
END;
$year = date('Y');
for($i=-1; $i<=6; $i++){
  echo "<option value=".($year+$i).">".($year+$i)."</option>";
};
//array used to convert the option number for schoolyear to the corresponding string
$optionToSchoolyear = ["","Freshman","Sophomore","Junior","Senior","Alumni","Other"];
echo <<<END

</select> 
<br/> 
 
<label for="schoolyear">Year</label> 
<select name="schoolyear" required> 
	<option value="{$user['schoolyear']}">optionToSchoolyear[$user['schoolyear']]</option>
	<option value="1">Freshman</option> 
	<option value="2">Sophomore</option> 
	<option value="3">Junior</option> 
	<option value="4">Senior</option> 
	<option value="5">Alumni</option> 
	<option value="6">Other</option> 
</select> 
<br/> 
 
<b>Contact</b><br/> 
<label for="email">Email</label> 
<input type="text" name="email" value = "{user['email']}" required/> 
<br/>
<label for="phone">Phone</label>
<input type="text" name="phone" value = "{user['phone']}" maxlength="10"/> 
 <!--
<label for="ar">Phone</label> 
<input type="text" name="ar" maxlength="3" pattern=[\d]{3}/> 
  
<input type="text" name="phone3d" maxlength="3" pattern=[\d]{3}/>
 
<input type="text" name="phone4d" maxlength="4" pattern=[\d]{4}/>-->
<br/> 
END;
//Grabbing address info from the address table
$db = newPDO();
$sql = "SELECT * FROM `Address` WHERE M_Id = $user['id'] LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->execute();
$userAddress = fetch();
echo <<<END
<label for="local">Local Address*</label> 
<input type="text" name="localaddress" value = "{userAddress['localaddress']}" maxlength="60" required/> 
<br/> 
 
<label for="perm"><b>Permanent Address:</b></label><br/>
street #
<input type="text" name="homeaddress" value = "{userAddress['homeaddress']}" maxlength="60" required/> 
<br/> 
citystatezip
<input type="text" name="citystatezip" value = "{userAddress['citystatezip']}" maxlength="30" required/> 
<br/> 
END;
/*

<input type="hidden" name="stage" value="process" />
 	<p align="left"><input type="submit" value="Submit" /></p>
</form> 

END;

}

function process_form() {

	$firstname = $_POST['firstname']; 
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$bday = $_POST['byear']."-".$_POST['bmonth']."-".$_POST['bday'];
	
	#contact
	$homeaddress = $_POST['homeaddress'];
	$citystatezip = $_POST['citystatezip'];
	$localaddress = $_POST['localaddress'];
	$email = $_POST['email'];
	//$phone = "(".$_POST['ar'].") ".$_POST['phone3d']."-".$_POST['phone4d']; 
	$phone = $_POST['phone'];
    #school info
	$schoolyear = $_POST['schoolyear'];
	$major = $_POST['major'];
	$minor = $_POST['minor'];
	
	$gradsem = $_POST['gradsem'];
	$gradyear = $_POST['gradyear'];
	 
    $pledgesem = $_POST['pledgesem'];
	$pledgeyear = $_POST['pledgeyear'];
	
	$status = $_POST['status'];
	$flower = $_POST['flower'];
	$regpass = $_POST['regpass'];
	#value of 1 means nothing as of now need to create new table to hold
	#auto_incrememted concurrent sems
	$active_semester = 1;



	$firstname = htmlspecialchars($firstname, ENT_QUOTES);
	$lastname = htmlspecialchars($lastname, ENT_QUOTES);
	$username = htmlspecialchars($username, ENT_QUOTES);
	$password = htmlspecialchars($password, ENT_QUOTES);
	$homeaddress = htmlspecialchars($homeaddress, ENT_QUOTES);
	$citystatezip = htmlspecialchars($citystatezip, ENT_QUOTES);
	$localaddress = htmlspecialchars($localaddress, ENT_QUOTES);
	$email = htmlspecialchars($email, ENT_QUOTES);
	$regpass = htmlspecialchars($regpass, ENT_QUOTES);

	$password = md5($password);

	if ($regpass == 'SpringRush2013') {

		$db = newPDO();  

		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );


		$sql =  "INSERT INTO `Member` ( firstname,lastname,username,password,email,Flower_Id,
			phone,birthday,schoolyear,gradsem,gradyear,pledgesem,pledgeyear,Status_Id,active_sem) 
		  VALUES (:fn,:ln,:un,:pass,:email,:flower,:phone,:birthday,:schoolyear,:gradsem,
			:gradyear,:pledgesem,:pledgeyear,:Status_Id,:active_sem)";

		$stmt = $db->prepare($sql);

		$stmt->execute(array(':fn'=>$firstname,
							':ln'=>$lastname,
						    ':un'=>$username,
					   	    ':pass'=>$password,
						    ':email'=>$email,
						    ':flower'=>$flower,
						    ':phone'=>$phone,
						    ':birthday'=>$bday,
						    ':schoolyear'=>$schoolyear,
						    ':gradsem'=>$gradsem,
						    ':gradyear'=>$gradyear,
						    ':pledgesem'=>$pledgesem,
						    ':pledgeyear'=>$pledgeyear,
						    ':Status_Id'=>$status,
						    ':active_sem'=>$active_semester));

	    print_r($stmt->errorInfo());
		$affected_rows = $stmt->rowCount();
		echo $affected_rows."<br/>";

	  	$lastInsert = $db->lastInsertId();
	  	echo $lastInsert;

	  	$sql = "INSERT INTO `Address` (M_Id,homeaddress,citystatezip,localaddress)
	  			VALUES (:id,:home,:citystatezip,:local)";

	  	$stmt = $db->prepare($sql);

	  	$stmt->execute(array(':id'=>$lastInsert,
	  						':home'=>$homeaddress,
	  						':citystatezip'=>$citystatezip,
	  						':local'=>$localaddress));

	  	print_r($stmt->errorInfo());
		$affected_rows = $stmt->rowCount();
		echo $affected_rows."<br/>";

		$sql = "INSERT INTO MajorRoster (M_Id,Major_Id)
					VALUES (:id,:m_id)";
		$major_stmt = $db->prepare($sql);

		$sql = "INSERT INTO MinorRoster (M_Id,Minor_Id)
					VALUES (:id,:m_id)";
		$minor_stmt = $db->prepare($sql);

		foreach($major as $ma){
			$major_stmt->execute(array(':id'=>$lastInsert,':m_id'=>$ma));
			print_r($major_stmt->errorInfo());
		}

		foreach($minor as $mi){
			$minor_stmt->execute(array(':id'=>$lastInsert,':m_id'=>$mi));
			print_r($minor_stmt->errorInfo());
		}

echo <<<END
		<div class="entry"><strong>Thank you for registering with APO-Epsilon!</strong></div>
END;

	} else {
		echo '<div class="entry"><strong>Your registration password was incorrect.  Please try again.<br />If you do not know your registration pass please contact the webmaster.</strong></div>';
		print_form();
	}
}

//if this is the first time viewing the page, print the form
//if not, process the form

//require_once ('layout.php');
//require_once ('mysql_access.php');
//page_header();

if (isset($_POST['stage']) && ('process' == $_POST['stage'])) { 
   process_form(); 
} else {
	print_form(); 
} 

echo "</div>";
//page_footer();
 ?>
