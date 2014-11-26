<?php

class User
{
	public $name;
	public $gender;
	
	function index(){
		 print "User Object Created<br/>";
	}
	public function __construct($name=NULL)
	{
		
		if(empty($name))
			$this->name = 'John Doe';
		else $this->name = $name;
	}	
	
	public function gender($gender)
	{
		$gender = strtolower($gender);
		if(empty($gender)){
			$this->gender = 'Unknown';
		}elseif(($gender == 'male')||($gender == 'female')){
			$this->gender = $gender;
		}
		return $this->gender;
	}
	
}