<?php
//include('module.php');
include('./modules/User/User.module.php');
$User = new User();
$User->__construct();
$User->gender('male');
print ($User->name." ".$User->gender);
