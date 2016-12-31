<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

<div class="row">

<?php

function show_exec() {
    if(isset($_GET['page_id'])) {
        list_exec_by_page();
    } else if(isset($_GET['position_id'])) {
        list_page_by_exec();
    } else {
        echo "<div class='small-12 columns text-center'><h2>Permissions Manager</h2></div>";
        list_pages();
        list_positions();
    }
}

function add_permission($pageId, $execId) {
    include('mysql_access.php');
    $sql = "SELECT page FROM exec_permissions_pages WHERE entry_id=$pageId;";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $page = $row['page'];
    $sql = "SELECT position FROM positions WHERE position_id=$execId;";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $position = $row['position'];
    $sql = "INSERT INTO exec_permissions (page, position) VALUES (\"$page\", \"$position\");";
    $result = $db->query($sql);
    if(!$result) {
        echo "Error: Could not add $position permission for $page";
    } else {
        echo "$position permission added for $page";
    }
}

function list_exec_by_page() {
    include('mysql_access.php');
    if(isset($_GET['remove'])) {
        $sql = "SELECT position_id FROM positions WHERE position=\"{$_GET['remove']}\";";
        $result = $db->query($sql);
        $row = mysqli_fetch_array($result);
        remove_permission($_GET['page_id'], $row['position_id']);
    } elseif(isset($_GET['add'])) {
        add_permission($_GET['page_id'], $_GET['add']);
    }
    $pageId = $_GET['page_id'];
    $sql = "SELECT page FROM exec_permissions_pages WHERE entry_id=$pageId;";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    echo "<a href='{$_SERVER['PHP_SELF']}' class='button'>< Back to main page</a>";
    echo "<div class=\"small-12 columns\">";
    echo "<h2>Current Exec with Permission for {$row['page']}</h2>";
    echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"GET\">";
    echo "<input type=\"hidden\" name=\"page_id\" value=\"$pageId\" />";
    echo "<label for=\"add\">Add Exec</label>";
    echo "<select name=\"add\">";
    $sql = "SELECT position, position_id FROM positions;";
    $result = $db->query($sql);
    while($row = mysqli_fetch_array($result)) {
        echo "<option value=\"{$row['position_id']}\">{$row['position']}</option>";
    }
    echo "</select><input type='submit' class='button' value='Add' /></form>";
    $sql = "SELECT exec_permissions.position AS position FROM exec_permissions_pages INNER JOIN exec_permissions ON exec_permissions.page=exec_permissions_pages.page WHERE exec_permissions_pages.entry_id=$pageId;";
    $result = $db->query($sql);
    echo "<table><tr><th>Position</th><th>Remove Exec</th></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr><td>{$row['position']}</td><td><a href=\"{$_SERVER['PHP_SELF']}?page_id=$pageId&remove={$row['position']}\" class=\"button expand\">Remove</a></td></tr>";
    }
    echo "</table></div>";
}

function list_page_by_exec() {
    if(isset($_GET['remove'])) {
        remove_permission($_GET['remove'], $_GET['position_id']);
    } elseif(isset($_GET['add'])) {
        add_permission($_GET['add'], $_GET['position_id']);
    }
    include('mysql_access.php');
    $sql = "SELECT position FROM positions WHERE position_id={$_GET['position_id']};";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $position = $row['position'];
    echo "<a href='{$_SERVER['PHP_SELF']}' class='button'>< Back to main page</a>";
    echo "<div class=\"small-12 columns\">";
    echo "<h2>Current Page Permissions for $position</h2>";
    echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"GET\">";
    echo "<input type=\"hidden\" name=\"position_id\" value=\"{$_GET['position_id']}\" />";
    echo "<label for=\"add\">Add Page</label>";
    echo "<select name=\"add\">";
    $sql = "SELECT entry_id, page FROM exec_permissions_pages ORDER BY page ASC;";
    $result = $db->query($sql);
    while($row = mysqli_fetch_array($result)) {
        echo "<option value=\"{$row['entry_id']}\">{$row['page']}</option>";
    }
    echo "</select><input type='submit' class='button' value='Add' /></form>";
    $sql = "SELECT exec_permissions.page AS page, exec_permissions_pages.entry_id AS page_id FROM exec_permissions_pages INNER JOIN exec_permissions ON exec_permissions.page=exec_permissions_pages.page WHERE exec_permissions.position=\"$position\" ORDER BY exec_permissions.page ASC;";
    $result = $db->query($sql);
    echo "<table><tr><th>Page</th><th>Remove Permission</th></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr><td>{$row['page']}</td><td><a href=\"{$_SERVER['PHP_SELF']}?position_id={$_GET['position_id']}&remove={$row['page_id']}\" class=\"button expand\">Remove</a></td></tr>";
    }
    echo "</table></div>";
}

function list_pages() {
    include('mysql_access.php');
    $sql = "SELECT page, entry_id FROM exec_permissions_pages ORDER BY page ASC;";
    $result = $db->query($sql);
    echo "<div class=\"medium-6 small-12 columns\">";
    echo "<h2>Current Pages</h2>";
    echo "<table><tr><th>Page Name</th><th>Edit Permissions</th></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr><td>{$row['page']}</td><td><a href=\"{$_SERVER['PHP_SELF']}?page_id={$row['entry_id']}\" class=\"button expand\">Edit</a></td></tr>";
    }
    echo "</table></div>";
}

function list_positions() {
    include('mysql_access.php');
    $sql = "SELECT position, position_id FROM positions ORDER BY position_order ASC;";
    $result = $db->query($sql);
    echo "<div class=\"medium-6 small-12 columns\">";
    echo "<h2>Current Positions</h2>";
    echo "<table><tr><th>Position</th><th>Edit Permissions</th></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr><td>{$row['position']}</td><td><a href=\"{$_SERVER['PHP_SELF']}?position_id={$row['position_id']}\" class=\"button expand\">Edit</a></td></tr>";
    }
    echo "</table></div>";
}

function remove_permission($pageId, $execId) {
    include('mysql_access.php');
    $sql = "SELECT page FROM exec_permissions_pages WHERE entry_id=$pageId;";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $page = $row['page'];
    $sql = "SELECT position FROM positions WHERE position_id=$execId;";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $position = $row['position'];
    $sql = "DELETE FROM exec_permissions WHERE page='$page' AND position='$position';";
    $result = $db->query($sql);
    if(!$result) {
        echo "Error: Could not remove $position permission for $page";
    } else {
        echo "$position permission removed for $page";
    }
}

$exec_page = true;
$active_page = false;
$public_page = false;

require_once('permissions.php');

?>

</div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
