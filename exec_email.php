<?php

require_once ('mysql_access.php');
require_once ('officer_functions.php');

function exec_email($result) {
	if ($result == get_exec_info(1)) {
		echo "apo.epsilon.president@gmail.com";
	}
	elseif ($result == get_exec_info(2)) {
		echo "apo.epsilon.largeservice@gmail.com";
	}
	elseif ($result == get_exec_info(3)) {
		echo "apo.epsilon.regularservice@gmail.com";
	}
	elseif ($result == get_exec_info(6)) {
		echo "apo.epsilon.membership@gmail.com";
	}
	elseif ($result == get_exec_info(4)) {
		echo "apo.epsilon.pledging@gmail.com";
	}
	elseif ($result == get_exec_info(7)) {
		echo "apo.epsilon.sergeant@gmail.com";
	}
	elseif ($result == get_exec_info(8)) {
		echo "apo.epsilon.pr@gmail.com";
	}
	elseif ($result == get_exec_info(9)) {
		echo "apo.epsilon.recsec@gmail.com";
	}
	elseif ($result == get_exec_info(10)) {
		echo "apo.epsilon.treasurer@gmail.com";
	}
	elseif ($result == get_exec_info(11)) {
		echo "apo.epsilon.scouting@gmail.com";
	}
	elseif ($result == get_exec_info(12)) {
		echo "apo.epsilon.broho@gmail.com";
	}
	elseif ($result == get_exec_info(13)) {
		echo "apo.epsilon.alumni@gmail.com";
	}
	elseif ($result == get_exec_info(14)) {
		echo "apo.epsilon.comsec@gmail.com";
	}
	elseif ($result == get_exec_info(15)) {
		echo "apo.epsilon.chaplain@gmail.com";
	}
	elseif ($result == get_exec_info(16)) {
		echo "apo.epsilon.rushchair@gmail.com";
	}
	elseif ($result == get_exec_info(17)) {
		echo "apo.epsilon.historian@gmail.com";
	}
	elseif ($result == get_exec_info(25)) {
		echo "apo.epsilon.fundraising@gmail.com";
	}
	elseif ($result == get_exec_info(18)) {
		echo "apo.epsilon.formal@gmail.com";
	}
	elseif ($result == get_exec_info(19)) {
		echo "apo.epsilon.icr@gmail.com";
	}
	elseif ($result == get_exec_info(20)) {
		echo "apo.epsilon.webmaster@gmail.com";
	}
	elseif ($result == get_exec_info(26)) {
		echo "apo.epsilon.redcross@gmail.com";
	}
	elseif ($result == get_exec_info(27)){
		echo "apo.epsilon.philanthropy@gmail.com";
	}
	elseif($result == get_exec_info(31)){
		echo "apo.epsilon.stbaldricks@gmail.com";
	}
}

?>

