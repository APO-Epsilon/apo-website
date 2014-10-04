<?php
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('functions.php');
$id=$_GET['id'];
page_header();
$result = get_history_content($id);
echo ('<div class= "content">');
echo $result['content'];
echo('</div>');
page_footer();?>