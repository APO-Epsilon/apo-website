<?php
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('officer_functions.php');
page_header();

echo ('<div class= "content">');

exec_page();

echo('</div>');
page_footer();?>