<?php

class Member{

	public $userID, $firstname, $lastname;
	
	/**
	 * The construct function is created after a user authenticates
	 * with the website using their username and password
	 * 
	 * To initialize $_SESSION['Member'] = new user(username);
	 */
	public function __construct($username){
		$sql = "SELECT userID, firstname, lastname 
				FROM contact_information 
				WHERE username = $username";
		$query_str = mysql_query($sql);
		$result = mysql_fetch_array($query_str);
		$this->userId;
		$this->firstname = $result['firstname'];
		$this->lastname = $result['lastname'];
	}

}
