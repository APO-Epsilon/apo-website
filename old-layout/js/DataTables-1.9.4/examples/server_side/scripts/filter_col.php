<?php
  /* MySQL connection */
	include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" ); /* ;-) */
	
	/* 
	 * Local functions
	 */
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}

	
	/* 
	 * MySQL connection
	 */
	if ( ! $gaSql['link'] = ($GLOBALS["___mysqli_ston"] = mysqli_connect( $gaSql['server'],  $gaSql['user'],  $gaSql['password']  )) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! ((bool)mysqli_query( $gaSql['link'] , "USE $gaSql['db']")) )
	{
		fatal_error( 'Could not select database ' );
	}


	
	/* Paging */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['iDisplayStart'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")).", ".
			((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['iDisplayLength'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	}
	
	/* Ordering */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['iSortingCols'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")) ; $i++ )
		{
			$sOrder .= fnColumnToField(((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['iSortCol_'.$i] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")))."
			 	".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['sSortDir_'.$i] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")) .", ";
		}
		$sOrder = substr_replace( $sOrder, "", -2 );
	}
	
	/* Filtering - NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE ( engine LIKE '%".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['sSearch'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""))."%' OR ".
		                "browser LIKE '%".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['sSearch'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""))."%' OR ".
		                "platform LIKE '%".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['sSearch'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""))."%' OR ".
		                "version LIKE '%".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['sSearch'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""))."%' OR ".
		                "grade LIKE '%".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['sSearch'] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""))."%' )";
	}
	
	for ( $i=0 ; $i<$_GET['iColumns'] ; $i++ )
	{
		if ( $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere != "" )
			{
				$sWhere .= " AND ";
			}
			else
			{
				$sWhere .= "WHERE ";
			}
			$sWhere .= fnColumnToField($i) ." LIKE '%".((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET['sSearch_'.$i] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""))."%'";
		}
	}
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS id, engine, browser, platform, version, grade
		FROM   ajax
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysqli_query( $gaSql['link'] ,  $sQuery) or fatal_error( 'MySQL Error: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) );
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query( $gaSql['link'] ,  $sQuery) or fatal_error( 'MySQL Error: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) );
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(id)
		FROM   ajax
	";
	$rResultTotal = mysqli_query( $gaSql['link'] ,  $sQuery) or fatal_error( 'MySQL Error: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)) );
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	$sOutput = '{';
	$sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';
	$sOutput .= '"iTotalRecords": '.$iTotal.', ';
	$sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
	$sOutput .= '"aaData": [ ';
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$sOutput .= "[";
		$sOutput .= '"'.str_replace('"', '\"', $aRow['engine']).'",';
		$sOutput .= '"'.str_replace('"', '\"', $aRow['browser']).'",';
		$sOutput .= '"'.str_replace('"', '\"', $aRow['platform']).'",';
		if ( $aRow['version'] == "0" )
			$sOutput .= '"-",';
		else
			$sOutput .= '"'.str_replace('"', '\"', $aRow['version']).'",';
		$sOutput .= '"'.str_replace('"', '\"', $aRow['grade']).'"';
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';
	
	echo $sOutput;
	
	
	function fnColumnToField( $i )
	{
		if ( $i == 0 )
			return "engine";
		else if ( $i == 1 )
			return "browser";
		else if ( $i == 2 )
			return "platform";
		else if ( $i == 3 )
			return "version";
		else if ( $i == 4 )
			return "grade";
	}
?>