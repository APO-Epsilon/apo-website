<?php

class Header { 
	
	private $head;

	function index()
		{
			//print "Header object created<br/>";
		}
		
	/**
	 * head loads the page header
	 * @param array item add files to be included for the page
	 * 		use <link re..... http://apo...... />
	 */	
	function head($item)
		{	
			$this->head = '
			<!DOCTYPE html>
			<head>
				<meta http-equiv="content-type" content="text/html; charset=utf-8" />
				<!--<link rel="stylesheet" type="text/css" href="http://apo.truman.edu/includes/css/styles.css"/>-->
			';
			
			foreach($item as $i){
				$this->head = $this->head.$i;
			}
			
			$this->head = $this->head."</head>";
			print $this->head;		
		}
	
}










