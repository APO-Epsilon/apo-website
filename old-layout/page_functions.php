<?php

function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data); 

    $pattern = '/\'/';
    $replacement = '%7843';
    $data = preg_replace($pattern, $replacement, $data);


    return $data;
}

function _restoreOriginal($order){
/*
	$min = 2;

	$sql = "DELETE FROM _posts WHERE ID > $min AND menu_order = $order";
	$result = mysql_query($sql);
	if(!$result){
		die (mysql_error());
	}else{
		echo('<meta HTTP-EQUIV="REFRESH" content="0; url=http://apo.truman.edu/">');
	}
*/
	echo("Please contact the webmaster if you wish to revert to an earlier revision");
}

function _processForm(){

	$post_parent = $_POST['postData'];
	$menu_order = $_POST['menu_order'];
	$content = check_input($_POST['content']);
	$title = check_input($_POST['title']);
	$excerpt = check_input($_POST['excerpt']);
	$today = date("Y-m-d H:i:s"); 

	$sql = "UPDATE _posts SET post_status = 'draft' WHERE post_parent = $post_parent";
	$result = mysql_query($sql);
	if(!$result){
		die(mysql_error().$sql);
	}

	$sql = "INSERT INTO _posts (post_content, post_title, post_excerpt, post_parent, menu_order, post_status, post_modified) 
			VALUES ('".$content."', '".$title."','".$excerpt."',".$post_parent.",".$menu_order.",'".$_POST['status']."','".$today."')";

	$result = mysql_query($sql);
	if(!$result){
		die(mysql_error().$sql);
	}else{
		echo('<meta HTTP-EQUIV="REFRESH" content="0; url=http://apo.truman.edu/">');
	}

}

function getPost($order){

	$sql = "SELECT * FROM `_posts` WHERE menu_order = $order ORDER BY ID";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
		$post_content = $r['post_content'];
		$post_title = $r['post_title'];
		$post_excerpt = $r['post_excerpt'];
		$post_parent = $r['post_parent'];
		$menu_order = $r['menu_order'];
		$status = $r['post_status'];
	}	
		$checkedPublish = $checkedDraft = '';
		if($status == 'publish'){
			$checkedPublish = 'checked';

		}else{
			$checkedDraft = 'checked';
		}
		$postData = array($post_content, $post_title, $post_excerpt, $post_parent, $menu_order, $checkedPublish, $checkedDraft);
		return $postData;

}

function _displayForm($order){

	$postArray = $p = getPost($order);
	$theContent = $p[0];
	$theTitle = $p[1];
	$theExcerpt = $p[2];
	$post_parent = $p[3];
	$menu_order = $p[4];
	$checkedPublish = $p[5];
	$checkedDraft = $p[6];

	$ROWS = $COLS = 80;
	
echo<<<FORM
	<form method="POST" action="$_SERVER[PHP_SELF]">
		STATUS :&nbsp;&nbsp; published  <input type="radio" name="status" value="publish" {$checkedPublish}> | draft  <input type="radio" name="status" value="draft" {$checkedDraft}> <br/>
		TITLE: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="title" size="32" value="$theTitle"/><br/>
		CONTENT: <textarea autofocus="autofocus" rows="$ROWS" cols="$COLS" name="content">$theContent</textarea><br/>
		EXCERPT: <textarea name="excerpt" row="$ROWS" cols="$COLS" name="excerpt">$theExcerpt</textarea><br/>
		<input type="hidden" name="submit" value="yes"/>
		<input type="hidden" name="postData" value="$post_parent"/>
		<input type="hidden" name="menu_order" value="$menu_order"/>
    	<input type="submit" value="submit"/>
    </form>

    <form method="post" action="$_SERVER[PHP_SELF]"> 
		<input type="Submit" name="restore" value="Restore Original (Cannot be redone)

"> 
	</form>

FORM;
}

function _displayPage($order){
	$Post = getPost($order);
	$content = $Post[0];

	$pattern = '/%7843/';
    $replacement = '\'';
    $content = preg_replace($pattern, $replacement, $content);

	$title = $Post[1];
	echo "<h1>".$title."</h1><p>";
	echo nl2br($content);
}
?>