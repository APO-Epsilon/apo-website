<?php

$module_base_dir = './modules/'; //Directory of modules (You can use absolute path)
$module_ext = '.module.php'; // Our Module Extension
$module_base_file = $module.$module_ext;  // not used

DEFINE('IS_IN_MODULE', true); //Define that this is the module controller

	$module = scandir($module_base_dir, 1);
	$moduleDirSize = count($module);
	$moduleFiles = array();
	foreach($module as $m){
		if($m != ".." && $m != "."){
			$moduleFiles[] = array($module_base_dir.$m.'/'.$m.$module_ext, $m);
		}
	}

foreach($moduleFiles as $m){

if(file_exists($m[0]))
{
        if(isset($_GET['function'])) //Check if we have defined a function
        {
                $function = $_GET['function']; //Assign the function to a variable
        }
        else
        {
                $function = 'index'; // if no function assign function index
        }
        include($m[0]); // Include our module
        $moduleClass = new $m[1]; // This Will launch our plugin constructor.
        if(method_exists($moduleClass, $function)) // Check our function exists
        {
                $moduleClass->$function(); //Call the function defined above
        }
        else
        {
                die("Function not found!"); // Show error message
        }
}
else
{
   die("Module Not Found!!");
}
}
?>