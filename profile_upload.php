<?php
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('profile_functions.php');
page_header();

echo ('<div class= "content">');

$userID = $_SESSION['sessionID'];

$path = getcwd()."\personnel_images\\".$userID;
$results = scandir($path);



// store references to the most recent file in the DB
// 

//if $results -- they have an uploaded file

/*print_r($results);
foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;

    if (is_dir($path . '/' . $result)) {
        echo $result;        
    }
}*/
echo ('</div>');

?>